<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\Services\ChatRoomService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(ChatRoomService::class, function($app){
            return new ChatRoomService(Auth::user()->chatUser);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
