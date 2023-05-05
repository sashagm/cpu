## CPU Sniffer

С помощью данного пакета можно управлять ЧПУ. Для вывода ЧПУ ссылок по условию в Laravel с помощью Route bind. SLUG OR ID.


#### Установка

- composer require sashagm/cpu
- php artisan vendor:publish --provider="Sashagm\Cpu\Providers\CPUServiceProvider"



#### Использование 

1. В файле `config/cfg.php` добавить параметр `cpu_url`, который будет определять, какой тип ссылок будет использоваться:

```php

'cpu_url' => env('CPU_URL', 'id'), // 'id' - вывод по id, 'slug' - вывод по slug

```

2. В модели `Post` определить метод `getRouteKeyName()`, который будет возвращать имя поля в зависимости от значения параметра `cpu_url`:

```php
class Post extends Model
{
    public function getRouteKeyName()
    {
        return config('cfg.cpu_url') == 'slug' ? 'slug' : 'id';
    }
}
```

3. В методе `boot()` класса `CPUServiceProvider` зарегистрировать связывание параметра маршрута с моделью с учетом значения параметра `cpu_url`:



```php

public function boot()
{

    Route::bind('post', function ($value) {
        $query = config('cfg.cpu_url') == 'slug' ? 'slug' : 'id';
        return App\Models\Post::where($query, $value)->firstOrFail();
    });
}

```

4. Пример Route Items.

```php

Route::get('/post/{post}', function (App\Models\Post $post) {

    dump($post);
    
})->name('post');
```


Теперь при обращении к маршруту `/posts/my-first-post` будет загружена модель `Post` с полем `slug` равным `my-first-post`, если параметр `cpu_url` установлен в значение 'slug'. Если же параметр `cpu_url` равен 'id', то будет загружена модель с соответствующим идентификатором. Если параметр `cpu_url` установлен в любое другое значение, будет выброшено исключение.

