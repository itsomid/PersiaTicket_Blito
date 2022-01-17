<?php

namespace App\Http\Controllers\Panel;

use App\Models\Order;
use App\Models\Showtime;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalSales = Order::whereStatus('approved')->sum('price');
        $ordersCount = Order::whereStatus('approved')->count();
        $activeUsersCount = User::has('orders')->count();
        $usersCount = User::count();
        $showtimes = Showtime::whereStatus('enabled')->get();
        return view('panel.dashboard',['total_sales' => $totalSales,'orders_count' => $ordersCount, 'active_users_count' => $activeUsersCount, 'users_count' => $usersCount,'showtimes' => $showtimes]);
    }
}
