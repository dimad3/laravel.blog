<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        //$posts = Post::with('category');
        $posts = Post::with('category')->orderBy('created_at', 'desc')->paginate(3);
        //dd (compact('posts'));
        return view('posts.index', compact('posts'));
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

        $post = Post::where('slug', $slug)->firstOrFail();
        // dump($post);
        // dd(compact('post'));
        $post->views +=1;
        $post->update();
        return view('posts.show', compact('post'));
    }
}
