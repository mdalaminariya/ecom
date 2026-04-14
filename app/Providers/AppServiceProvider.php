<?php

namespace App\Providers;

use App\Models\Message;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Blog;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Share cart data with all views
       View::composer('*', function ($view) {
    $cartItems = collect();
    $cartCount = 0;
    $cartTotal = 0;

    if (Auth::check()) {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $cartCount = $cartItems->sum('quantity');

     $cartTotal = $cartItems->sum(function($item) {
    return $item->product->price * $item->quantity;
});
    }

    $view->with(compact('cartItems', 'cartCount', 'cartTotal'));

      View::composer('*', function ($view) {
        $view->with('blogs', Blog::latest()->take(5)->get());
    });
});

    View::composer('layouts.frontendmaster.master', function ($view) {
        $view->with('blogs', Blog::all());
    });

    //customize the email verification notification
  VerifyEmail::toMailUsing(function ($notifiable, $url) {
    return (new MailMessage)
        ->subject('Verify Your Email Address')
        ->view('emails.verify-design', [
            'url' => $url,
            'user' => $notifiable,
        ]);
});

View::composer('*', function ($view) {

        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();

        // unread messages count
        $unreadCount = Message::where('receiver_id', $userId)
            ->where('is_read', 0)
            ->count();

        // latest messages per user (NO duplicates)
        $sub = Message::selectRaw('MAX(id) as id')
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->groupByRaw("
                CASE
                    WHEN sender_id = ? THEN receiver_id
                    ELSE sender_id
                END
            ", [$userId]);

        $latestMessages = Message::with(['sender', 'receiver'])
            ->whereIn('id', $sub)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $view->with([
            'unreadCount' => $unreadCount,
            'latestMessages' => $latestMessages
        ]);
    });
}
}
