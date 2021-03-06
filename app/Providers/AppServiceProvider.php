<?php

namespace App\Providers;

use App\Category;
use App\Comment;
use App\Post;
use App\Subscription;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Schema::defaultStringLength(191);

        view()->composer(
            'pages._sidebar',function($view){
                $view->with('popularPosts', Post::getPopularPosts());
                $view->with('featuredPosts', Post::getFeaturedPosts());
                $view->with('recentPosts',Post::getRecentPosts());
                $view->with('categories',Post:: getCategories());

            }
        );


        view()->composer(
            'admin._sidebar',function($view){
            $view->with('newCommentsCount', Comment::where('status',0)->count());
            $view->with('SubscribersCount', Subscription::where('token',null)->count());


        }
        );
    }
}
