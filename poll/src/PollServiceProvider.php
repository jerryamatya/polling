<?php
namespace GeniusSystems\Poll;
/**
 * Created by PhpStorm.
 * User: jerryamatya
 * Date: 11/13/20
 * Time: 13:01
 */
use Illuminate\Support\ServiceProvider;

class PollServiceProvider extends ServiceProvider
{


    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    public function register()
    {
        $this->app->bind(MinIOStorageServiceProvider::class, function ($app) {
            return new MinIOStorageServiceProvider();
        });

    }

}