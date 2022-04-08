<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;



class AuditLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('audit', function($app)
        {
            return new \App\Models\AuditLog;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /* App::bind('auditLog', function()
        {
            return new \App\Facades\AuditLog;
        }); */
    }
}
