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

CPU Sniffer - это пакет для Laravel, который позволяет управлять ЧПУ (человекопонятными ссылками) в вашем приложении. Он использует функционал Laravel Route bind для определения, какой параметр использовать в URL: SLUG или ID. А так же вы можете быстро переключаться между режимами и выводить уникальные ссылки вашим пользователям.

### Оглавление:

- [Требования](#требования)
- [Установка](#установка)
- [Использование](#использование)
  - [Применение роутов](#применение-роутов)
- [Дополнительные возможности](#дополнительные-возможности)        
- [Тестирование](#тестирование)
- [Лицензия](#лицензия)

#### Требования

Основные требования для установки и корректной работы:

- `PHP` >= 8.0
- `Laravel` >= 10.x
- `Composer` >= 2.4.x

#### Установка

- composer require sashagm/cpu
- php artisan cpu:install


#### Использование

После установки пакета, вам необходимо выполнить следующие шаги:

1. В конфигурационном файле `/config/cfg.php` определите параметры `cpu_url` и `routes`.
2. В параметре `cpu_url`, который будет определять, какой тип ссылок будет использоваться. 
3. В параметре `routes` определите необходимые маршруты с указанием имени, модели и запроса.
4. Запустите команду `php artisan optimize` для обновления маршрутов.

Пример конфигурационного файла cfg.php:

```php
return [
    'cpu_url' => 1,  // 1 - Режим slug, 0 - Режим id
    'routes' => [
        [
            'name' => 'post',   // Маршрут
            'model' => 'App\Models\Post', // Модель
            'query' => ['slug'] // Параметр для slug
        ],
        [
            'name' => 'user',
            'model' => 'App\Models\User',
            'query' => ['id']
        ]
    ]
];
```

В данном примере определены два маршрута: `post и user`. Для маршрута post используется модель `App\Models\Post` и параметр `slug` в запросе, а для маршрута user - модель `App\Models\User` и параметр `id` в запросе.

Таким образом, мы можем добавлять новые роуты и соответствующие им модели в массив `routes` в конфиге `/config/cfg.php`, а метод `boot()` будет автоматически биндить их при запуске приложения.

Итак, теперь наш функционал более гибкий и позволяет работать с различными типами ссылок.

##### Применение роутов
Пример Route Items.

```php

Route::get('/post/{post}', function (App\Models\Post $post) {

    dump($post);
    
})->name('post');
```


Теперь при обращении к маршруту `/posts/my-first-post` будет загружена модель `Post` с полем `slug` равным `my-first-post`, если параметр `cpu_url` установлен в значение 'slug'. Если же параметр `cpu_url` равен 'id', то будет загружена модель с соответствующим идентификатором. Если параметр `cpu_url` установлен в любое другое значение, будет выброшено исключение.

#### Дополнительные возможности

Наш пакет предоставляет ряд дополнительных возможностей, которые могут быть полезны при работе с чпу:

- `php artisan cpu:install` - Данная команда установит все необходимые файлы.

#### Тестирование

Для проверки работоспособности можно выполнить специальную команду:

- ./vendor/bin/phpunit --configuration phpunit.xml

#### Лицензия

CPU Sniffer - это программное обеспечение с открытым исходным кодом, лицензированное по [MIT license](LICENSE.md ).


