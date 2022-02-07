<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function show($slug)
    {
        // https://laravel.com/docs/7.x/collections#method-where
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->orderBy('created_at', 'desc')->paginate(5);

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
        $categories = Category::all();
        //dd(compact('posts'));
        return view('categories.show', compact('posts', 'categories'));
    }
}
