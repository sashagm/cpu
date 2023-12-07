<?php

namespace  Sashagm\Cpu\Traits;

use Exception;
use Illuminate\Support\Facades\Route;

trait RouteBindingTrait
{
    public function bootRouteBinding()
    {
        if (!file_exists(config('cfg'))) {
            return false;
        }


        $config = config('cfg');

        $this->validateConfig($config);

        $routes = $config['routes'];

        foreach ($routes as $route) {
            
            $this->validateRoute($route);

            $query = $this->getQuery($route, $config['cpu_url']);

            $this->bindRoute($route, $query);
        }
    }

    protected function validateConfig($config)
    {
        if (!isset($config['cpu_url'])) {
            throw new Exception('Missing cpu_url in config/cfg.php');
        }

        if (!isset($config['routes'])) {
            throw new Exception('Missing routes in config/cfg.php');
        }
    }

    protected function validateRoute($route)
    {
        if (!isset($route['name'])) {
            throw new Exception('Missing name for route in config/cfg.php');
        }

        if (!isset($route['model'])) {
            throw new Exception('Missing model for route in config/cfg.php');
        }

        if (!isset($route['query'])) {
            throw new Exception('Missing query for route in config/cfg.php');
        }

        if (!class_exists($route['model'])) {
            throw new Exception('Model ' . $route['model'] . ' not found');
        }
    }

    protected function getQuery($route, $cpuUrl)
    {
        return $cpuUrl == 1 ? ['slug'] : $route['query'];
    }

    protected function bindRoute($route, $query)
    {
        Route::bind($route['name'], function ($value) use ($route, $query) {
            $model = new $route['model'];
            foreach ($query as $param) {
                $model = $model->where($param, $value);
            }
            return $model->firstOrFail();
        });
    }
}
