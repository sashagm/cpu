<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">

<a href="https://packagist.org/packages/sashagm/cpu"><img src="https://img.shields.io/packagist/dt/sashagm/cpu" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/sashagm/cpu"><img src="https://img.shields.io/packagist/v/sashagm/cpu" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/sashagm/cpu"><img src="https://img.shields.io/packagist/l/sashagm/cpu" alt="License"></a>
<a href="https://packagist.org/packages/sashagm/cpu"><img src="https://img.shields.io/github/languages/code-size/sashagm/cpu" alt="Code size"></a>
<a href="https://packagist.org/packages/sashagm/cpu"><img src="https://img.shields.io/packagist/stars/sashagm/cpu" alt="Code size"></a>

[![PHP Version](https://img.shields.io/badge/PHP-%2B8-blue)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-%2B10-red)](https://laravel.com/)

</p>


## CPU Sniffer

С помощью данного пакета можно управлять ЧПУ. Для вывода ЧПУ ссылок по условию в Laravel с помощью Route bind. SLUG OR ID.

### Оглавление:

- [Установка](#установка)
- [Как работает](#как-работает)
  - [Применение роутов](#применение-роутов)
- [Тестирование](#тестирование)
- [Лицензия](#лицензия)

#### Установка

- composer require sashagm/cpu
- php artisan vendor:publish --provider="Sashagm\Cpu\Providers\CPUServiceProvider"



#### Как работает

1. В файле `config/cfg.php` добавить параметр `cpu_url`, который будет определять, какой тип ссылок будет использоваться.
Также можно добавить возможность указывать несколько параметров для поиска в модели, например, если нужно искать модель по нескольким полям. 


```php


return [
    'cpu_url' => 0,
    'routes' => [
        [
            'name' => 'post',
            'model' => 'App\Models\Post',
            'query' => ['id', 'slug'],
        ],
        [
            'name' => 'user',
            'model' => 'App\Models\User',
            'query' => ['id', 'email'],
        ],
        // другие роуты и модели
    ],
];



```




2. В модели которой будем бидить надо определить метод `getRouteKeyName()`, который будет возвращать имя поля в зависимости от значения параметра `cpu_url` на примере модели `Post`:

```php
class Post extends Model
{
    public function getRouteKeyName()
    {
        switch (config('cfg.cpu_url')) {
            case 0:
                return 'id';
            case 1:
                return 'slug';
            default:
                throw new Exception('Invalid value for cpu_url in config/cfg.php');
        }
    }
}
```

Таким образом, мы можем добавлять новые роуты и соответствующие им модели в массив routes в конфиге cfg, а метод boot() будет автоматически биндить их при запуске приложения.

3. Обновление V2.0.0

Мы также добавили проверку наличия модели в конфигурационном файле, чтобы избежать ошибок при неправильном указании модели. Также мы дали возможность указывать несколько параметров для поиска в модели, например, если нужно искать модель по нескольким полям. Для этого мы изменили логику функции-замыкания, чтобы она строила запрос с помощью метода where() для каждого параметра из массива query в конфиге.

Итак, теперь наш функционал более гибкий и позволяет работать с различными типами ссылок.


##### Применение роутов
4. Пример Route Items.

```php

Route::get('/post/{post}', function (App\Models\Post $post) {

    dump($post);
    
})->name('post');
```


Теперь при обращении к маршруту `/posts/my-first-post` будет загружена модель `Post` с полем `slug` равным `my-first-post`, если параметр `cpu_url` установлен в значение 'slug'. Если же параметр `cpu_url` равен 'id', то будет загружена модель с соответствующим идентификатором. Если параметр `cpu_url` установлен в любое другое значение, будет выброшено исключение.

#### Тестирование

Для проверки работоспособности можно выполнить специальную команду:

- ./vendor/bin/phpunit --configuration phpunit.xml

#### Лицензия

CPU Sniffer - это программное обеспечение с открытым исходным кодом, лицензированное по [MIT license](LICENSE.md ).


