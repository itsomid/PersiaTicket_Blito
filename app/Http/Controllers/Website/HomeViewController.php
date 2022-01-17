<?php

namespace App\Http\Controllers\Website;

use App\Models\Category;
use App\Models\City;
use App\Models\Genre;
use App\Models\Order;
use App\Models\Show;
use App\Http\Controllers\API\ShowsController;
use App\Models\Ticket;
use App\User;
use function Clue\StreamFilter\append;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use IntlDateFormatter;
use Cache;


class HomeViewController extends Controller
{
    //
    public function home(Request $request)
    {

        if ($request->session()->has('cityid')) {
            $cityid = $request->session()->get('cityid');
        } else {
            $cityid = 1;
        }

//        $consert = Show::whereCategoryId(1)->get();
//        $teater = Show::whereCategoryId(2)->pluck('id');
//        $event = Show::whereCategoryId(3)->pluck('id');
//
//
//        $allshow = [];
//        $x = 0;
//        for($i=0;$i < count($consert);$i++)
//        {
//            if ($i < count($consert)) {
//
//                $allshow[$x] = $consert[$i];
//                $x++;
//            }
//            if ($i<count($teater)) {
//
//                $allshow[$x] = $teater[$i];
//                $x++;
//            }
//            if ($i<count($event)) {
//
//                $allshow[$x] = $event[$i];
//                $x++;
//            }
//        }
//        return $allshow;
//        $ids_ordered = implode(',', $allshow);
//        $page = request()->has('page') ? request()->get('page') : 1;
//        $shows = Cache::rememberForever('show' . $page, function ()use ($cityid,$allshow,$ids_ordered)  {
//            $collection = Show::where('status','enabled')->where('city_id',$cityid)->whereIn('id',$allshow)->orderByRaw(\DB::raw("FIELD(id, $ids_ordered)"));
//            return $collection = $collection->paginate(50);
//        });
//        $categoryhasgenre = Cache::rememberForever('category', function () {
//            return Category::with('genres')->get();
//        });
//        $cities = Cache::rememberForever('cities', function () {
//            return City::has('shows')->get();
//        });
//        $genres = Cache::rememberForever('genre', function () {
//            return Genre::has('shows')->get();
//        });
//        $showhasgenres = Cache::rememberForever('show_genre', function () {
//            return Show::with('genres')->get();
//        });
//        return Order::with('tickets')->where('status','approved')->where('sum','!=','price')->get();
//        $orders = Order::with('tickets')->where('status','approved')->get();
//        $bad_order =[];
//        foreach ($orders as $order)
//        {
//            if ($order->sum != $order->price){
//               $bad_order[] = $order;
//            }
//        }
//        return $bad_order;
//        return $orders->where('sum','!=',$orders->price);
//        return Ticket::where('ticket_info->row','2')->distinct('order_id')->get();
        $shows = Show::where('status','enabled')->where('city_id',$cityid)->orderBy('created_at','DESC')->get();
        $categoryhasgenre = Category::with('genres')->get();
        $cities = City::has('shows')->get();
        $genres = Genre::has('shows')->get();
        $showhasgenres =  Show::with('genres')->get();

        $cover = Show::where('is_cover', 1)->first();


        return view('website.welcome', compact('shows', 'cities', 'genres', 'showhasgenres', 'categoryhasgenre', 'cover'));

    }

    public function homeCity(Request $request)
    {

        if ($request->isMethod('post')) {

            $cityid = $request->id;

            $request->session()->put('cityid', $cityid);

            return 1;
        } else {
        }

    }

    public function search(Request $request)
    {

        if ($request->ajax()) {

            if (session('cityid') == null) {
                $request->session()->put('cityid', '1');
            }
            $search = $request->get('search');
            $city_id = session('cityid');




                $result =  Category::with(['shows' => function ($query) use ($city_id, $search) {

                    $query = $query->where('status', '=', "enabled");
                    $query = $query->where('city_id', '=', $city_id);

                    $query = $query->where(function ($query) use ($search) {
                        $query->where('title', 'LIKE', "%$search%")
                            ->orWhere('artist_name', 'LIKE', "%$search%")
                            ->orWhere('subtitle', 'LIKE', "%$search%")
                            ->orWhere('description', 'LIKE', "%$search%");
                    });
                }])->get();

            $output = "";
            $i = 0;
//            dd(strlen($search));
            if (strlen($search) >= 5) {
                if ($search) {
                    if ($result) {
                        foreach ($result as $key => $shows) {
                            foreach ($shows->shows as $show) {
                                if ($show->from_date == $show->to_date) {
                                    $date = \SeebBlade::prettyDateWithFormat($show->from_date, 'd MMM');
                                } else {
                                    $date = \SeebBlade::prettyDateWithFormat($show->from_date, 'd MMM') . " تا" . \SeebBlade::prettyDateWithFormat($show->to_date, 'd MMM ');
                                }
                                $routeshow = route('website/get/show', ['uid' => $show->uid]);
                                $output .=
                                    "<a  href='$routeshow' >" .
                                    "<img src='$show->thumb_url'>" .
                                    '<div>' .
                                    '<span>' . $show->title . '</span>' .
                                    '<br>' .
                                    '<span>' . $show->artist_name . '</span>' .
                                    '<br>' .
                                    '<span class="dark-gray">' . $date . '</span>' .
                                    '</div>' .
                                    '</a>';
                                $i = $i + 1;
                                if ($i == 5) {
                                    break;
                                }
                            }
                            if ($i == 5) {
                                break;
                            }
                        }
                        $request->session()->flash('search_result', $result);
                        $routesearch = route('website/search/view', ['search_key' => $request->get('search')]);
                        if ($output) {
                            $output .= "<a href='$routesearch' class='show_all_event'> " . "نمایش همه (Enter)" . '</a>';
                        } else {
                            return 0;
                        }
                    }
                } else {
                    return 0;
                }
            } else {
                $output = "...";
            }
            return Response($output);
        }

    }


}