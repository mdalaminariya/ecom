<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index()
{
    // Total Users
    $totalUsers = User::count();

    // Users online in last 5 minutes
    $onlineUsers = User::where('last_active_at', '>=', Carbon::now()->subMinutes(5))->count();

    // Total Orders
    $totalOrders = Order::count();

    // Total Completed Sales (all time)
    $totalSales = Order::where('status', 'completed')->sum('total_amount');

    // Daily Sales (this week)
    $dailySales = Order::where('status', 'completed')
                        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->sum('total_amount');

    // Latest 10 Users
    $newUsers = User::where('role', 'user')->where('is_banned', false)->latest()->take(10)->get();

    // Latest 10 Orders
    $recentOrders = Order::latest()->take(10)->get();

    return view('dashboard.home.index', compact(
        'totalUsers',
        'onlineUsers',
        'totalOrders',
        'totalSales',
        'dailySales',
        'newUsers',
        'recentOrders',

    ));
}
}
