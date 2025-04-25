<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libraries\Menu;

class MenuServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register any services if needed.
    }

    public function boot()
    {
        $this->app->booted(function () {
            /*
            * Initialize Main Menu Items
            */
            Menu::addMenuItem("main-menu", [
                "id"    => "home",
                "title" => "Home",
                "link"  => url('/'), // Use Laravel's url() helper.
                "icon"  => "fa fa-home"
            ]);
        
            /*
            * Initialize Admin Menu Items
            */
            Menu::addMenuItem("admin-menu", [
                "id"    => "admin-dashboard",
                "title" => "Home",
                "link"  => url_to_pager('admin-dashboard'), // Make sure 'admin-dashboard' is defined
                "icon"  => "fa fa-home"
            ]);
        
            Menu::addMenuItem("admin-menu", [
                "id"    => "add-task-page",
                "title" => "Add Task",
                "link"  => url_to_pager('create-task'),
                "icon"  => "fa fa-add"
            ]);
        
            Menu::addMenuItem("admin-menu", [
                "id"    => "task-categories",
                "title" => "Categories",
                "link"  => url_to_pager('task-categories'),
                "icon"  => "fa fa-clone"
            ]);
        
            Menu::addMenuItem("admin-menu", [
                "id"    => "logout",
                "title" => "Logout",
                "link"  => url_to_pager('logout'),
                "icon"  => "fa fa-sign-out"
            ]);
        
            /*
            * Define Menu Locations
            */
            Menu::addLocation('main-menu', 'Main Menu');
            Menu::addLocation('admin-menu', 'Admin Menu');
        });
    }
}
