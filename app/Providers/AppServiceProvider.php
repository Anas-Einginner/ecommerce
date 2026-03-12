<?php

namespace App\Providers;

use App\Http\Controllers\MessageController;
use App\Models\ContactMessage;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
     View::composer('*', function ($view) {

        $recentMessages = ContactMessage::where('created_at','>=',Carbon::now()->subDays(3))
            ->latest()
            ->take(5)
            ->get();
           $messagesCount = ContactMessage::where('created_at','>=',Carbon::now()->subDays(3))
            ->count();

 $view->with([
            'recentMessages'=>$recentMessages,
            'messagesCount'=>$messagesCount
        ]);    });
    }
}
