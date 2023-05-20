<?php

namespace Sashagm\Cpu\Providers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class CPUServiceProvider extends ServiceProvider
{
    protected $cpuUrl;

    public function __construct($app)
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
         $routes = config('cfg.routes');
     
         foreach ($routes as $route) {
             switch ($this->cpuUrl) {
                 case 0:
                     $query = $route['query'];
                     break;
                 case 1:
                     $query = ['slug']; // или другой параметр для ЧПУ
                     break;
                 default:
                     throw new Exception('Invalid value for cpu_url in config/cfg.php');
             }
     
             if (!class_exists($route['model'])) {
                 throw new Exception('Model '.$route['model'].' not found');
             }
     
             Route::bind($route['name'], function ($value) use ($route, $query) {
                 $model = new $route['model'];
                 foreach ($query as $param) {
                     $model = $model->where($param, $value);
                 }
                 return $model->firstOrFail();
             });
         }
     }
}


