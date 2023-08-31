<?php

namespace Sashagm\Cpu\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Sashagm\Cpu\Providers\CPUServiceProvider;


class CreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cpu:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Данная команда создаст необходимые файлы пакета cpu.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->components->info('Установка пакета...');
        $this->install();
        $this->components->info('Установка завершена!');
        
    }

    protected function install(): void
    {
        Artisan::call('vendor:publish', [
            '--provider' => CPUServiceProvider::class,
            '--force' => true,
        ]);
        $this->components->info('Сервис провайдер опубликован...');

    }



}