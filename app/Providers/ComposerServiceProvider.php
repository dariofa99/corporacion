<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {


        View::composer([
            'content.categories.*',            
        ], 'App\Http\ViewComposers\CategoriesComposer');

        View::composer([
            'content.users.user_edit',
            'content.front.user.*',
            'content.users.users_list',
            'content.users.partials.modals.asignacion_rol',
            'content.users.partials.ajax.*',
            'auth.register'
        ], 'App\Http\ViewComposers\UsersComposer');

        View::composer([
            'content.cases.create',
            'content.cases.edit',
            'content.cases.index',
            'content.cases.partials.ajax.*',

        ], 'App\Http\ViewComposers\CasesComposer');

        View::composer([
            'layouts.sidebar',

        ], 'App\Http\ViewComposers\SidebarComposer');
        View::composer([
            'front.sidebar',
            'content.front.navbar',
        ], 'App\Http\ViewComposers\FrontSidebarComposer');

        View::composer([
            'content.diary.index',
            'content.front.diary.index'
        ], 'App\Http\ViewComposers\DiaryComposer');
        View::composer([
            'content.front.payments.*',
        ], 'App\Http\ViewComposers\FrontComposer');

        View::composer([
            'content.directory.*',
        ], 'App\Http\ViewComposers\DirectoryComposer');
        View::composer([
            'content.panic_api.*',
        ], 'App\Http\ViewComposers\PanicAlertComposer');
    }
}
