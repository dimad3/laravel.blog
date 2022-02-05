<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index(){
        //$posts = Post::with('category');
        $posts = Post::with('category')->orderBy('created_at', 'desc')->paginate(3);
        //dd (compact('posts'));
        return view('posts.index', compact('posts'));
    }

    public function show($slug){
        $post = Post::find($slug);
        dd($post);
        return view('posts.show', compact($post));
    }
}
