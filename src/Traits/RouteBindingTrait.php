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
            if (!isset($route['name'])) {
                throw new Exception('Missing name for route in config/cfg.php');
            }

            if (!isset($route['model'])) {
                throw new Exception('Missing model for route in config/cfg.php');
            }

            if (!isset($route['query'])) {
                throw new Exception('Missing query for route in config/cfg.php');
            }

            $query = $config['cpu_url'] == 1 ? ['slug'] : $route['query'];

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
