<?php

namespace  Sashagm\Cpu\Traits;


use Exception;
use Illuminate\Support\Facades\Route;

trait RouteBindingTrait
{
    public function bootRouteBinding()
    {
        $config = config('cfg');

        if (!isset($config['cpu_url'])) {
            throw new Exception('Missing cpu_url in config/cfg.php');
        }

        if (!isset($config['routes'])) {
            throw new Exception('Missing routes in config/cfg.php');
        }

        $routes = $config['routes'];

        foreach ($routes as $route) {
            $query = $config['cpu_url'] == 1 ? ['slug'] : ($route['query'] ?? []);

            if (!class_exists($route['model'])) {
                throw new Exception('Model ' . $route['model'] . ' not found');
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
