<?php

namespace M74asoud\TempTag;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use M74asoud\TempTag\Services\TagService;
use M74asoud\TempTag\Services\TempTagService;

class TempTagServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        if (File::exists(__DIR__ . '/helper.php')) {
            require __DIR__ . '/helper.php';
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
