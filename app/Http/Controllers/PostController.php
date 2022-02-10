<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class PostController extends Controller
{
    public function index()
    {
        //$posts = Post::with('category');
        $posts = Post::with('category')->orderBy('created_at', 'desc')->paginate(10);
        //dd (compact('posts'));
        $categories = Category::all();
        return view('posts.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        /**
         * vendor\laravel\framework\src\Illuminate\Database\Eloquent\Builder.php
         *
         * public function findOrFail($id, $columns = ['*'])
         *
         * Find a model by its primary key or throw an exception.
         *
         * @param  mixed  $id
         * @param  array  $columns
         * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static|static[]
         *
         * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
         */

        /**
         * vendor\laravel\framework\src\Illuminate\Database\Eloquent\Builder.php
         *
         * public function firstOrFail($columns = ['*'])
         *
         * Execute the query and get the first result or throw an exception.
         *
         * @param  array  $columns
         * @return \Illuminate\Database\Eloquent\Model|static
         *
         * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
         */

        // https://laravel.com/docs/7.x/collections#method-where
        $post = Post::where('slug', $slug)->firstOrFail();
        // dump($post);
        // dd(compact('post'));
        $post->views += 1;

        /**
         * vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php
         *
         * public function update(array $attributes = [], array $options = [])
         *
         * Update the model in the database.
         *
         * @param  array  $attributes
         * @param  array  $options
         * @return bool
         */
        $post->update();

        /**
         * vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php
         *
         * public static function all($columns = ['*'])
         *
         * Get all of the models from the database.
         *
         * @param  array|mixed  $columns
         * @return \Illuminate\Database\Eloquent\Collection|static[]
         */
        return view('posts.show', compact('post'));
    }
}
