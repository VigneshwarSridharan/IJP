<?php

namespace App\Providers;

use \TCG\Voyager\Models\Category;
use Illuminate\Support\Facades\View;
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
        //
        $categories = Category::all()->toArray();
        
        $categories = array_map(function($category) {
            return [
                "order" => $category['order'],
                "name" => $category['name'],
                "slug" => $category['slug'],
                "id" => $category['id'],
                "image" => $category['image']
            ];
        },$categories);
        array_multisort(array_column($categories, 'order'), SORT_ASC, $categories);
        View::share('categories',$categories);
    }
}
