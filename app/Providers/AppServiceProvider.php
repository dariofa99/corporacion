<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Repositories\BaseRepository;
use App\Repositories\UsersRepository;
use App\Services\UsersService;
use GuzzleHttp\Client;

use function PHPUnit\Framework\returnSelf;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('GuzzleHttp\Client',function(){
            return new Client(
                ['base_uri'=>'http://apichat.local/']
            );
        }); 
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        $this->app->bind(
            UsersService::class,
            UsersRepository::class,
            BaseRepository::class
        );
        
       // dd("#.,fñl");
        //$this->app->singleton(Client::class);
    }
}
