<?php

namespace App\Http\Controllers;

use App\Classes\Seeb\Vendors\SeebTiwall;
use App\Models\Order;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class TiwallController extends Controller
{

    public function paymentsCallback(Request $request, $order_uid)
    {

//        return $request->input('zb_result');
//         $result = json_decode($request->input('result'));
          $result = json_decode($request->input('zb_result'));

        if(!is_null($result)) {

            /** @var Order $order */
            $order = Order::findByUID($order_uid);



            $order = Order::with('tickets')->whereSourceRelatedId($order->source_related_id)->where('source_id',2)->firstOrFail();
            // temporary
            $agent = new Agent();
            if ($agent->isDesktop())
            {
                $failed = route('website/bank/result',['result' => 0, 'order_uid' => $order->uid]);
                $success = route('website/bank/result',['result' => 1, 'order_uid' => $order->uid]);
            }
            else{
                $failed = route('bank/result',['result' => 0, 'order_uid' => $order->uid]);
                $success = route('bank/result',['result' => 1, 'order_uid' => $order->uid]);
            }
            if($result->ok)
            {
                if($order->source_details['trace_number'] == $result->data->trace_number)
                {
                    //seems OK
                    //check to make sure
                    $tiwall = new SeebTiwall();
                    $check = $tiwall->checkReserve($result->data->sale->urn, $result->data->reserve_id,$result->data->trace_number);
                    if($check->getStatusCode() == 200)
                    {
                        //Ticket::newTicketForExternalTicket($order)
                        $checkObj = json_decode($check->getBody()->getContents());
                        if($checkObj->ok)
                        {
                            // TODO: check reserve state and create tickets based on the returned response


                            if ($checkObj->data->state == "reserved") {

                                $order->status = 'approved';
                                foreach ($order->tickets as $key => $ticket) {
                                    $ticket->code = $result->data->verification_data[$key];
                                    $ticket->status = 'sold';
                                    $ticket->save();
                                }
                                $source_details = $order->source_details;
                                $source_details['pdf'] = $result->data->attachment_url;
                                $order->source_details = $source_details;
                                $order->save();

                                return response()->redirectTo($success);
                            }
                        }
                    }else {
                        \Log::debug("Tiwall check order #$order->id failed: ".$check->getStatusCode());

                    }

                }
            }
            else{

                return redirect($failed);
            }
        }
        return abort(400);
    }
}
