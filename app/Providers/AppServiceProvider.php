<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Post;
use App\Policies\PostPolicy;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */ public function register()
    {
        //
    }

    public function boot()
    {
        Paginator::useBootstrap();
    }
}
