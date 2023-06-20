<?php

namespace Sashagm\Cpu\Providers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Sashagm\Cpu\Traits\RouteBindingTrait;


class CPUServiceProvider extends ServiceProvider
{
    protected $cpuUrl;

    use RouteBindingTrait;

    public function __construct(Application $app)
    {
        parent::__construct($app);
    
        $this->cpuUrl = config('cfg.cpu_url');
    }

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


     public function boot()
     {
        $this->bootRouteBinding();
     }
}


