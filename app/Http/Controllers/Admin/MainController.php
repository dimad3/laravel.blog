<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Category;

class MainController extends Controller
{
    public function index()
    {
        Category::create([
            'title' => 'My Awesome Blog Post',
        ]);

        // https://laravel.com/docs/7.x/helpers#method-view
        /**
         * Get the evaluated view contents for the given view.
         *
         * @param  string|null  $view
         * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
         * @param  array  $mergeData
         * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
         *
         * function view($view = null, $data = [], $mergeData = [])
         */
        return view('admin.index');
    }

}
