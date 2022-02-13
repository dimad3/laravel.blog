<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Category;
use App\Post;
use Illuminate\Support\Facades\Cache;

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
        /**
         * public static function composer($views, $callback) { }
         *
         * @param array|string $views
         * @param \Closure|string $callback
         *
         * @return array
         */
        View::composer(['layouts.sidebar'], function ($view) {

            /**
             *
             * public function with($key, $value = null);
             *
             * Add a piece of data to the view.
             *
             * @param  string|array  $key
             * @param  mixed  $value
             * @return $this
             */

            /**
             * vendor\laravel\framework\src\Illuminate\Database\Query\Builder.php
             *
             * public function orderBy($column, $direction)
             *
             * Add an "order by" clause to the query.
             *
             * @param  \Closure|\Illuminate\Database\Query\Builder|\Illuminate\Database\Query\Expression|string  $column
             * @param  string  $direction
             * @return $this
             *
             * @throws \InvalidArgumentException
             */
            $view->with('sidebar_posts', Post::orderBy('views', 'desc')->orderBy('created_at', 'desc')->limit(5)->get());
        });


        View::composer(['*'], function ($view) {
            // https://laravel.com/api/7.x/Illuminate/Support/Facades/Cache.html#method_has
            if (Cache::has('cats')) {
                $cats = Cache::get('cats');
            } else {
                /**
                 * vendor\laravel\framework\src\Illuminate\Database\Eloquent\Concerns\QueriesRelationships.php
                 * https://laravel.com/docs/7.x/eloquent-relationships#counting-related-models
                 *
                 * public function withCount($relations)
                 *
                 * Add subselect queries to count the relations.
                 *
                 * @param  mixed  $relations
                 * @return $this
                 */
                $cats = Category::withCount('posts')->orderBy('posts_count', 'desc')->get();
                // https://laravel.com/api/7.x/Illuminate/Support/Facades/Cache.html#method_put
                Cache::put('cats', $cats, 30);
            }

            $view->with('cats', $cats);
        });
    }
}
