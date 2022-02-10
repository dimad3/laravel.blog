<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Tag;

class TagController extends Controller
{
    public function show($slug)
    {
        // https://laravel.com/docs/7.x/collections#method-where
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->with('category')->orderBy('created_at', 'desc')->paginate(10);

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
        return view('tags.show', compact('tag', 'posts'));
    }
}
