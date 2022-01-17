<?php
/**
 * Created by PhpStorm.
 * User: shahin
 * Date: 11/30/17
 * Time: 12:20 PM
 */

namespace App\Classes\Seeb\Vendors;

use App\Models\Show;
use App\Models\ShowSponsor;
use App\Models\Order;
use App\Models\Scene;
use App\Models\Showtime;
use App\Models\Ticket;
use App\User;
use GuzzleHttp\Client;

class SeebTiwall
{
    private $client;
    private $base_url = 'https://store.zirbana.com/v2/';
    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->base_url,'headers' => ['Zb-Auth' => '62:0330fa0af58603c3ba84dd815d35220fb1de5239']]);
    }

    public function retrieveShowURN($url) {

        if(!preg_match("/^https:\/\/www\.tiwall\.com.+/i", $url)) // `i` flag for case-insensitive
        {
            return $url;
        }
        $exploded = explode('/', $url);
        $end = end($exploded);
        return $end;
    }
    public function retrieveCategoryList($key)
    {
        $response = $this->client->get("pages/list?cat=$key&count=1000");
        return \GuzzleHttp\json_decode($response->getBody());
    }
    public function retrieveShowInfo($urn, $true_urn = false)
    {
        if($true_urn)
            $urn = $this->retrieveShowURN($urn);
        $response = $this->client->get("$urn/info");
        return \GuzzleHttp\json_decode($response->getBody());
    }
    public function retrieveShowInstances($urn, $true_urn = false)
    {
        if($true_urn)
            $urn = $this->retrieveShowURN($urn);
        $response = $this->client->get("$urn/instances");
        return \GuzzleHttp\json_decode($response->getBody());
    }
    public function retrieveShowSeatmapHtml($urn,$showtimeId)
    {
        $response = $this->client->get("$urn/seatmap?format=html&showtime_id=$showtimeId&_pretty=1");
        return $response->getBody()->getContents();
    }


    public function paymentURLForOrder(Order $order, $scheme)
    {
        if($order->source_id != 2)
        {
            return;
        }
        $url = $this->base_url.$order->source_details['urn']."/payment?reserve_id=".$order->source_details['reserve_id']."&trace_number=".$order->source_details['trace_number']."&callback=".route('tiwall/callback',['uid' => $order->uid]).'/';
        return $url;
    }
    /**
     * @param $urn
     * @param $seats
     * @param $showtime
     * @param $user
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function reserveTickets($seats, $showtime, \App\User $user)
    {
        $urn = $showtime->show->source_details['urn'];
        $fullName = $user->fullName();
        $mobile = $user->mobile;
        $email = $user->email;
        $sendSms = 1;
        $sendEmail = 1;
        $use_internal_receipt = 0;

        $response = $this->client->get("$urn/reserve?instance_id=$showtime->source_related_id&seats=$seats&user_fullname=$fullName&user_mobile=$mobile&user_email=$email&send_sms=$sendSms&send_email=$sendEmail");

        return $response;
    }


    /**
     * @param $urn
     * @param $reserve_id
     * @param $trace_number
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function checkReserve($urn, $reserve_id, $trace_number)
    {
        $response = $this->client->get("$urn/check?reserve_id=$reserve_id&trace_number=$trace_number");
        return $response;
    }
    public function importShow($urn,$category_id = 2, $city_id = 1)
    {
        $urn = $this->retrieveShowURN($urn);

        $info = $this->retrieveShowInfo($urn, true);
//         var_dump( $info->data->spec);
//        var_dump($info);
//        return 1;//->data->type;

        $show = Show::firstOrNew([
            'source_related_id' => $info->data->id,
            'source_id' => 2
        ]);

        $show->fill([
            'title' => $info->data->title_prefix . ' ' . $info->data->title,
            'subtitle' => '',
            'description' => is_null($info->data->desc) ? $info->data->short_desc : $info->data->desc,
            'from_date' => $info->data->spec->start_date,
            'to_date' => $info->data->spec->end_date,
            'thumb_url' => $info->data->image->thumb_url,
            'main_image_url' => $info->data->image->big_url,
            'city_id' => $city_id,
            'category_id' => $category_id,
            'source_details' => [
                'urn' => $urn
            ]
        ]);

        switch ($info->data->subject->urn) {
            case 'music':
                {
                    $show->artist_name = $info->data->title;
                }
                break;
        }
        $show->sponsors = [];
        $show->admin_id = User::first()->id;
        $show->status = 'enabled';
        $show->save();

        //['name', 'address', 'city', 'phone']
        $scene = Scene::firstOrNew([
            'source_related_id' => $info->data->spec->venue->id,
            'source_id' => 2
        ]);

        $scene->name = $info->data->spec->venue->title;

        $scene->phone = $info->data->spec->venue->tel;
        $scene->address = $info->data->spec->venue->address;
        if (isset($info->data->spec->venue->location)) {
            $scene->location = [$info->data->spec->venue->location->latitude,
            $info->data->spec->venue->location->longitude];
        }
        $scene->city = "";
        $scene->save();


         $instances = $this->retrieveShowInstances($urn,true);


        foreach ($instances->data as $instance)
        {
            $showtime = Showtime::firstOrNew([
                'source_related_id' => $instance->id,
                'source_id' => 2
            ]);
            $showtime->datetime = $instance->datetime;
            $showtime->scene_id = $scene->id;
            $showtime->show_id = $show->id;
            $showtime->status = 'enabled';
            $showtime->save();
        }

        return $show;

    }

}