<?php

namespace App\Http\Controllers\Panel;

use App\Classes\Seeb\Vendors\SeebTiwall;
use App\Models\Category;
use App\Models\City;
use App\Models\Genre;
use App\Models\Scene;
use App\Models\Seat;
use App\Models\Show;
use App\Models\ShowSponsor;
use App\Models\Showtime;
use App\Models\Source;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use function Psy\sh;

class ShowsController extends Controller
{

    public function index($cat_id, Request $request)
    {

        if (($request->has('sortby')))
        {
            $sort = $request->input('sortby');
        }
        else{
            $sort = "id";
        }

        $category = Category::find($cat_id);
        $user = $request->user();
        if($user->access_level == 10)
            $shows = $category->shows()->orderby($sort,'ASC')->get();
        else
            $shows = $category->shows()->orderby($sort,'ASC')->whereAdminId($request->user()->id)->get();
        return view('panel.shows',['category' => $category, 'shows' => $shows,'searchTerm' => null]);


    }

    public function search($cat_id, Request $request)
    {
        $term = $request->input('search-term');
        $category = Category::find($cat_id);
        $user = $request->user();
        if($user->access_level == 10)
            $shows = $category->shows();
        else
            $shows = $category->shows()->whereAdminId($request->user()->id);

        $shows = $shows->where(function($query) use($term) {
            $query->where('title','LIKE',"%$term%")
                ->orWhere('artist_name','LIKE',"%$term%")
                ->orWhere('subtitle','LIKE',"%$term%")
                ->orWhere('description','LIKE',"%$term%");
        });

        return view('panel.shows',['category' => $category, 'shows' => $shows->get(),'searchTerm' => $term]);
    }
    public function pendingShows()
    {
        return view('panel.pendingshows', ['shows' => Show::whereStatus('pending')->get()]);
    }
    public function approvalPending(Request $request)
    {
        $user = $request->user();
        if(!$user->isAdmin())
            return abort(403);

        $shows = Show::whereStatus('pending')->get();
        // TODO: Do something with unusable category here
        return view('panel.shows',['category' => Category::first(), 'shows' => $shows]);


    }
    public function approve($show_uid, Request $request)
    {
        $user = $request->user();
        if(!$user->isAdmin())
            return abort(403);
        $show = Show::findByUID($show_uid);
        $show->status = "enabled";
        $show->save();
        return response()->redirectToRoute('shows/show',['uid' => $show_uid]);
    }
    public function show($show_uid)
    {

          $show = Show::findByUID($show_uid);
          $report = $show->report();

        return view('panel.single-show', ['show' => $show, 'report_dates' => json_encode($report['chart_data_dates']), 'report_prices' => json_encode($report['chart_data_prices']), 'report' => $report, 'promotions' => $show->promotions]);
    }
    public function create($cat_id = 1)
    {

        return view('panel.create-show',['category' => Category::find($cat_id), 'show'=> null])->with('activeTab', 0);
    }
    public function edit($show_uid)
    {
        /** @var Show $show */
         $show = Show::findByUID($show_uid);
        //return \SeebBlade::prettyDateWithFormat($show->from_date,'y/M/d', 'en_IR');
//            return $show->showtimes;
        return view('panel.create-show',['category' => $show->category, 'show'=> $show])->with('activeTab', 0);
    }
    public function scene($id)
    {
        return view('panel.scene',['scene' => Scene::find($id)]);
    }
    public function import(Request $request)
    {

        $city_id = $request->input('city_id');
        $category_id = $request->input('category_id');
        $url = $request->input('url');
        $source_id = $request->input('source_id');
        switch($source_id)
        {
            case 2:
                //Tiwall
            {
                $tiwall = new SeebTiwall();

                try
                {
                    /** @var Show $show */
                     $show = $tiwall->importShow($url,$category_id,$city_id);

                }catch (\Exception $exception)
                {
                    return back()->withInput()->with(['importError' => 'اشکالی در دریافت اطلاعات رویداد از تیوال صورت گرفته است. جزئیات خطا:'."  ".$exception->getMessage(),'activeTab' => 1]);
                }

                if(isset($show))
                {
                    $show->background_color = str_replace_first("#","",$request->input('color'));
                    $show->save();
                    return redirect()->route('shows/show',['show_uid' => $show->uid]);
                }
                else
                {
                    return back()->withInput()->with(['importError' => 'اشکالی در دریافت اطلاعات رویداد از تیوال صورت گرفته است. دوباره سعی کنید','activeTab' => 1]);
                }

            }
            break;
        }
        //return
    }


    public function save(Request $request, $uid = null)
    {

        $id = $request->input('show_id');

        if (is_null($id)) {

            //return [$request->hasFile('sponsor1-logo')];
            $validator = Validator::make($request->all(), [
                "title" => "required",
                "from_date" => "required",
                "to_date" => "required",
                "startshowtime_date-1" => "required",
                "showtime_date-1" => "required",
                "cover" => "required",
                "thumb" => "required",
                "color" => "required",
                "priced_seats" => "required",
            ]);
            if ($validator->passes()) {


                $thumb = base64_decode(substr($request->input('thumb'), strpos($request->input('thumb'), ",") + 1));
                $thumb_url = "images/shows/thumb-" . time() . mt_rand(10000, 99999) . ".png";
                Storage::put("public/" . $thumb_url, $thumb, 'public');
                $thumb_url = asset("/storage/" . $thumb_url);
                $cover = base64_decode(substr($request->input('cover'), strpos($request->input('cover'), ",") + 1));
                $cover_url = "images/shows/cover-" . time() . mt_rand(10000, 99999) . ".png";
                Storage::put("public/" . $cover_url, $cover, 'public');
                $cover_url = asset("/storage/" . $cover_url);

                $show = new Show([
                    'title' => $request->input('title'),
                    //'artist_name' => $request->input('artist'),
                    //'subtitle' => $request->input('subtitle'),
                    'description' => $request->input('description'),
                    'from_date' => \SeebBlade::carbonFromPersian($request->input('from_date'), 'yyyy/MM/dd', false, true),
                    'to_date' => \SeebBlade::carbonFromPersian($request->input('to_date'), 'yyyy/MM/dd', false, true),
                    'thumb_url' => $thumb_url,
                    'main_image_url' => $cover_url,
                    'background_color' => str_replace_first("#","",$request->input('color')),
                    'category_id' => $request->input('category_id'),
                    'city_id' => $request->input('city_id')
                ]);


                $show->auto_selection = $request->input('auto_selection');
                $show->free = $request->input('freeReserve');


                $show->admin_id = $request->input('admin_id');
                if (\Auth::user()->access_level == 10){
                    $show->status = $request->input('status');
                    $show->ticket_status = $request->input('ticket_status');
                }
                else{
                    $show->status = "pending";
                    $show->ticket_status = "none";
                }
                if (!$request->user()->isAdmin())
                    $show->status = 'pending';

                $show->genres()->sync($request->input('genres'));
                if ($request->input('license') != "") {
                    $license = base64_decode(substr($request->input('license'), strpos($request->input('license'), ",") + 1));
                    $license_url = "licenses/lic-" . time() . mt_rand(10000, 99999) . ".png";
                    Storage::put("public/" .$license_url, $license, 'public');
                    $license_url = "/storage/" . $license_url;
                    $show->license_url = asset($license_url);
                }
                $sponsors = [];
                if ($request->input('sponsor1-name') != "") {
                    $logo_url = null;
                    if ($request->input('slogo1') != '') {
                        $thumb = base64_decode(substr($request->input('slogo1'), strpos($request->input('slogo1'), ",") + 1));
                        $thumb_url = "sponsor_logos/sponsor-" . time() . mt_rand(10000, 99999) . ".png";
                        Storage::put("public/" . $thumb_url, $thumb, 'public');
                        $logo_url = asset("/storage/" . $thumb_url);
                    }
                    $sponsor = new ShowSponsor($request->input('sponsor1-name'), $logo_url, '');
                    array_push($sponsors, $sponsor);
                }
                if ($request->input('sponsor2-logo') != "") {
                    $logo_url = null;
                    if ($request->input('slogo2') != '') {
                        $thumb = base64_decode(substr($request->input('slogo2'), strpos($request->input('slogo2'), ",") + 1));
                        $thumb_url = "sponsor_logos/sponsor-" . time() . mt_rand(10000, 99999) . ".png";
                        Storage::put("public/" . $thumb_url, $thumb, 'public');
                        $logo_url = asset("/storage/" . $thumb_url);
                    }
                    $sponsor = new ShowSponsor($request->input('sponsor2-name'), $logo_url, '');
                    array_push($sponsors, $sponsor);
                }
                $show->sponsors = $sponsors;
                $show->terms_of_service = $request->input('rules');
                $show->save();


                $scene_id = $request->input('scene');
                $scene = Scene::findOrFail($scene_id);


                $priced_seats = explode(',', $request->input('priced_seats'));
//                array_shift($priced_seats);
                $disabled_seats = explode(',', $request->input('disabled_seats'));
//                array_shift($disabled_seats);

                if ($scene->seats_count > (count($priced_seats) + count($disabled_seats))) {
                    // all seats are not set
                    //return back()->withInput()->with(['newError' => ['همه صندلی‌ها قیمت‌گذاری نشده‌اند. دوباره سعی کنید'],'activeTab' => 0]);
                    return ['result' => false, 'errors' => ['همه صندلی‌ها قیمت‌گذاری نشده‌اند. دوباره سعی کنید']];
                }

                $i = 1;

                // going to add showtimes
                while ($request->has("showtime_date-$i")) {
                    /** @var Carbon $date */

                    $date = \SeebBlade::carbonFromPersian($request->input("showtime_date-$i"), 'yyyy/MM/dd HH:mm', false, true);
                    $availableDate = \SeebBlade::carbonFromPersian($request->input("startshowtime_date-$i"), 'yyyy/MM/dd HH:mm', false, true);
                    $showtime = Showtime::createRawShowTimeForShow($show, $scene, $date, $availableDate);

                    foreach ($priced_seats as $priced_seat) {
                        if ($priced_seat == "")
                            continue;
                        $components = explode(':', $priced_seat);
                        $seat = Seat::find($components[0]);
                        $ticket = Ticket::create([
                            'price' => $components[1],
                            'seat_id' => $seat->id,
                            'showtime_id' => $showtime->id,
                            'status' => 'available',
                            'ticket_info' => [
                                'zone' => $seat->row->zone->name,
                                'row' => strval($seat->row->row),
                                'seat' => strval($seat->column)
                            ]
                        ]);
                        $ticket->save();
                    }

                    foreach ($disabled_seats as $disabled_seat) {
                        if ($disabled_seat == "")
                            continue;
                        $components = explode(':', $disabled_seat);

                        $seat = Seat::find($components[0]);
                        $ticket = Ticket::create([
                            'price' => 0,
                            'seat_id' => $seat->id,
                            'showtime_id' => $showtime->id,
                            'status' => 'disabled',
                            'ticket_info' => [
                                'zone' => $seat->row->zone->name,
                                'row' => strval($seat->row->row),
                                'seat' => strval($seat->column)
                            ]
                        ]);
                        $ticket->save();
                    }
                    $i++;
                }

                // DONE :D
                //return response()->redirectToRoute('shows/show',['show_uid' => $show->uid]);
                return ['result' => true];
            }
            //return back()->withInput()->with(['newError' => (array) $validator->errors()->all(),'activeTab' => 0]);
            return ['result' => false, 'errors' => (array)$validator->errors()->all()];
        }
        else{

            // Edit
            $validator = Validator::make($request->all(), [
                "title" => "required",
                "from_date" => "required",
                "to_date" => "required",
                "color" => "required",
            ]);
            if ($validator->passes())
            {
                $show = Show::findOrFail($id);

                if (!is_null($request->input('thumb')) && $request->input('thumb') != "")
                {
                    $thumb = base64_decode(substr($request->input('thumb'), strpos($request->input('thumb'), ",") + 1));
                    $thumb_url = "images/shows/thumb-" . time() . mt_rand(10000, 99999) . ".png";
                    Storage::put("public/" . $thumb_url, $thumb, 'public');
                    $thumb_url = "/storage/" . $thumb_url;
                    $show->thumb_url = asset($thumb_url);
                }
                if (!is_null($request->input('cover')) && $request->input('cover') != "")
                {
                    $cover = base64_decode(substr($request->input('cover'), strpos($request->input('cover'), ",") + 1));
                    $cover_url = "images/shows/cover-" . time() . mt_rand(10000, 99999) . ".png";
                    Storage::put("public/" . $cover_url, $cover, 'public');
                    $cover_url = "/storage/" . $cover_url;
                    $show->main_image_url = asset($cover_url);
                }

                $show->title = $request->input('title');
                $show->description = $request->input('description');
                $show->from_date = \SeebBlade::carbonFromPersian($request->input('from_date'), 'yyyy/MM/dd', false, true);
                $show->to_date = \SeebBlade::carbonFromPersian($request->input('to_date'), 'yyyy/MM/dd', false, true);
                $show->background_color = str_replace_first("#","",$request->input('color'));
                $show->category_id = $request->input('category_id');
                $show->city_id = $request->input('city_id');

                /** @var Show $show */
                $show->status = $request->input('status');
                $show->ticket_status = $request->input('ticket_status');

                if (!$request->user()->isAdmin())
                    $show->status = 'pending';

                $show->auto_selection = $request->input('auto_selection');
                $show->free = $request->input('freeReserve');
//

                $show->genres()->sync($request->input('genres'));
                if ($request->input('license') != "") {
                    $license = base64_decode(substr($request->input('license'), strpos($request->input('license'), ",") + 1));
                    $license_url = "licenses/lic-" . time() . mt_rand(10000, 99999) . ".png";
                    Storage::put("public/" .$license_url, $license, 'public');
                    $license_url = "/storage/" . $license_url;
                    $show->license_url = asset($license_url);
                }
                $update_sponsors = false;
                $sponsors = [];
                if ($request->input('sponsor1-name') != "") {
                    $update_sponsors = true;
                    $logo_url = null;
                    if ($request->input('slogo1') != '') {
                        $thumb = base64_decode(substr($request->input('slogo1'), strpos($request->input('slogo1'), ",") + 1));
                        $thumb_url = "sponsor_logos/sponsor-" . time() . mt_rand(10000, 99999) . ".png";
                        Storage::put("public/" . $thumb_url, $thumb, 'public');
                        $logo_url = asset("/storage/" . $thumb_url);
                    }
                    $sponsor = new ShowSponsor($request->input('sponsor1-name'), $logo_url, '');
                    array_push($sponsors, $sponsor);
                }
                if ($request->input('sponsor2-logo') != "") {
                    $update_sponsors = true;
                    $logo_url = null;
                    if ($request->input('slogo2') != '') {
                        $thumb = base64_decode(substr($request->input('slogo2'), strpos($request->input('slogo2'), ",") + 1));
                        $thumb_url = "sponsor_logos/sponsor-" . time() . mt_rand(10000, 99999) . ".png";
                        Storage::put("public/" . $thumb_url, $thumb, 'public');
                        $logo_url = asset("/storage/" . $thumb_url);
                    }
                    $sponsor = new ShowSponsor($request->input('sponsor2-name'), $logo_url, '');
                    array_push($sponsors, $sponsor);
                }
                if ($update_sponsors)
                {
                    $show->sponsors = $sponsors;
                }
                $show->terms_of_service = $request->input('rules');
                $show->save();
                return ['result' => true];
            }
            return ['result' => false, 'errors' => (array)$validator->errors()->all()];
        }
    }

    public function setCover($show_uid)
    {
        $confirmedshow = Show::where('is_cover',1)->first();
        if (!is_null($confirmedshow) ) {
            $confirmedshow->is_cover = 0;
            $confirmedshow->save();
        }

         $show = Show::findByUID($show_uid);
         $show->is_cover = 1;
         $show->save();
        return \Redirect::back();
    }

}
