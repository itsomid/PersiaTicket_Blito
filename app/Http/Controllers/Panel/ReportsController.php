<?php

namespace App\Http\Controllers\Panel;

use App\Models\Order;
use App\Models\Show;
use App\Models\Showtime;
use App\Models\Source;
use App\Models\Ticket;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function reportForShow($show_uid)
    {
        $show = Show::findByUID($show_uid);

        return view('panel.reports');
    }

    public function reportForUser($user_uid)
    {
        return view('panel.reports');
    }

    public function generalReport(Request $request)
    {


        if ($request->has('source') && $request->input('source') != -1) {
            $source_ids = [intval($request->input('source'))];
        } else {
            $source_ids = Source::selectRaw('id')->get()->toArray();;
            $source_ids = array_map(function ($o) {
                return $o['id'];
            }, $source_ids);
        }

        if ($request->has('producer') && $request->input('producer') != -1) {
            $user = User::find($request->input('producer'));
            $showIds = array_map(function ($o) {
                return \App\Models\Show::realId($o['uid']);
            }, $user->ownShows()->whereIn('source_id', $source_ids)->selectRaw('id')->get()->toArray());

            $orderIds = \App\Models\Order::whereIn('show_id', $showIds)->selectRaw('id')->get()->toArray();
            $orderIds = array_map(function ($o) {
                return \App\Models\Ticket::realId($o['uid']);
            }, \App\Models\Ticket::whereIn('order_id', $orderIds)->selectRaw('id')->get()->toArray());
            $totalShows = $user->ownShows()->where('status', 'enabled')->count();
        } else {

            $showIds = array_map(function ($o) {
                return \App\Models\Show::realId($o['uid']);
            }, \App\Models\Show::whereIn('source_id', $source_ids)->get()->toArray());
            $orderIds = \App\Models\Order::selectRaw('id')->get()->toArray();
            $orderIds = array_map(function ($o) {
                return \App\Models\Ticket::realId($o['uid']);
            }, \App\Models\Ticket::whereIn('order_id', $orderIds)->selectRaw('id')->get()->toArray());
            $totalShows = Show::where('status', 'enabled')->count();
        }

//        return $orderIds;
        $reportChart = Order::whereIn('show_id', $showIds)->select(\DB::raw('SUM(price) as total, DATE(created_at) as date'))->where('status', 'approved')->groupBy('date')->get();
        $totalSale = Order::whereIn('show_id', $showIds)->where('status', 'approved')->where('type', 'normal')->sum('price');
//         $totalSeats = Ticket::whereIn('order_id', $orderIds)->count();
         $totalSeats = Ticket::count();
         $totalSoldSeats = Ticket::where('status', 'sold')->count();
//         $totalSoldSeats = Ticket::whereIn('order_id', $orderIds)->where('status', 'sold')->count();

         $website_totalSold = Order::whereIn('show_id', $showIds)->where('status', 'approved')->where('type', 'normal')->where('agent','website')->sum('price');
        $website_orderIds = Order::where('agent','website')->selectRaw('id')->get()->toArray();
        $website_totalSoldSeates  = Ticket::whereIn('order_id', $website_orderIds)->where('status', 'sold')->count();
//
         $android_totalSold = Order::whereIn('show_id', $showIds)->where('status', 'approved')->where('type', 'normal')->where('agent','android')->sum('price');
        $android_orderIds = Order::where('agent','android')->selectRaw('id')->get()->toArray();
        $android_totalSoldSeates  = Ticket::whereIn('order_id', $android_orderIds)->where('status', 'sold')->count();
//
        $ios_totalSold = Order::whereIn('show_id', $showIds)->where('status', 'approved')->where('type', 'normal')->where('agent','ios')->sum('price');
        $ios_orderIds = Order::where('agent','ios')->selectRaw('id')->get()->toArray();
        $ios_totalSoldSeates  = Ticket::whereIn('order_id', $ios_orderIds)->where('status', 'sold')->count();
//

        $prices = array_map(function ($o) {
            return intVal($o['total']);
        }, $reportChart->toArray());
        $dates = array_map(function ($o) {
            return \SeebBlade::prettyDateWithFormat(\Carbon\Carbon::parse($o['date']), 'dd MMM yyyy');
        }, $reportChart->toArray());

        $totalProducers = User::where('access_level', 5)->count();
        $totalUsers = User::count();
        return view('panel.reports', ['users_count' => $totalUsers, 'producers_count' => $totalProducers, 'shows_count' => $totalShows, 'chart_prices' => json_encode($prices),
            'chart_dates' => json_encode($dates), 'total_sale' => $totalSale, 'total_seats' => $totalSeats, 'total_sold_seats' => $totalSoldSeats, 'source' => Source::find($request->input('source')),
            'producer' => User::find($request->input('producer'))
            ,'website_totalSold'=>$website_totalSold,'android_totalSold'=>$android_totalSold,'ios_totalSold'=>$ios_totalSold,
            'website_totalSoldSeats'=>$website_totalSoldSeates,'android_totalSoldSeats'=>$android_totalSoldSeates,'ios_totalSoldSeats'=>$ios_totalSoldSeates])->with('message','general');

    }

    public function singleReport(Request $request, $uid)
    {


        $showtime = Showtime::findByUID($uid);

        $orderIds = \App\Models\Order::selectRaw('id')->get()->toArray();
        $orderIds = array_map(function ($o) {
            return \App\Models\Ticket::realId($o['uid']);
        }, \App\Models\Ticket::whereIn('order_id', $orderIds)->selectRaw('id')->get()->toArray());


        $reportChart = Order::where('showtime_id', $showtime->id)->select(\DB::raw('SUM(price) as total, DATE(created_at) as date'))->where('status', 'approved')->groupBy('date')->get();
         $totalSale = Order::where('showtime_id', $showtime->id)->where('status', 'approved')->where('type', 'normal')->sum('price');
        $totalSeats = Ticket::where('showtime_id', $showtime->id)->count();
        $totalSoldSeats = Ticket::where('showtime_id', $showtime->id)->where('status', 'sold')->count();
         $website_totalSold = Order::with('tickets')->where('showtime_id', $showtime->id)->where('status', 'approved')->where('type', 'normal')->where('agent','website')->first();
         $android_totalSold = Order::with('tickets')->where('showtime_id', $showtime->id)->where('status', 'approved')->where('type', 'normal')->where('agent','android')->first();
         $ios_totalSold = Order::with('tickets')->where('showtime_id', $showtime->id)->where('status', 'approved')->where('type', 'normal')->where('agent','ios')->first();

//         return $website_totalSold->tickets;
        $prices = array_map(function ($o) {
            return intVal($o['total']);
        }, $reportChart->toArray());
        $dates = array_map(function ($o) {
            return \SeebBlade::prettyDateWithFormat(\Carbon\Carbon::parse($o['date']), 'dd MMM yyyy');
        }, $reportChart->toArray());

        $totalProducers = User::where('access_level', 5)->count();
        $totalUsers = User::count();
        return view('panel.reports', ['users_count' => $totalUsers, 'producers_count' => $totalProducers, 'shows_count' => 1, 'chart_prices' => json_encode($prices),
            'chart_dates' => json_encode($dates), 'total_sale' => $totalSale, 'total_seats' => $totalSeats, 'total_sold_seats' => $totalSoldSeats,
            'source' => Source::find($request->input('source')), 'producer' => User::find($request->input('producer'))
        ,'website_totalSold'=>$website_totalSold,'android_totalSold'=>$android_totalSold,'ios_totalSold'=>$ios_totalSold])->with('message', 'single');

    }
}
