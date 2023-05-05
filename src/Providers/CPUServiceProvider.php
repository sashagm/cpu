<?php

namespace Sashagm\Cpu\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class CPUServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        

        $this->publishes([
            __DIR__.'/../config/cfg.php' => config_path('cfg.php'),

        ]);



    Route::bind('users', function ($value) {
        $query = config('cfg.cpu_url') ? 'slug' : 'id';
        return  \App\Models\User::where($query, $value)->firstOrFail();
    });



    Route::bind('events', function ($value) {
        $query = config('cfg.cpu_url') ? 'slug' : 'id';
        return  \App\Models\Events::where($query, $value)->firstOrFail();
    });


    Route::bind('specials', function ($value) {
        $query = config('cfg.cpu_url') ? 'slug' : 'id';
        return  \App\Models\SpecialOffer::where($query, $value)->firstOrFail();
    });


    

            
    }
}
