<?php

namespace Ahmedtaha\TravellingSalesman;

use Illuminate\Support\ServiceProvider;

class TravellingSalesmanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->publishes([
            __DIR__.'/config/tsp.php' => config_path('tsp.php'),
        ],'tsp');
    }

    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/tsp.php', 'tsp'
        );
    }
}
