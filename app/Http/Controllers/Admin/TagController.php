<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::paginate(3);

        /**
         * view() - Get the evaluated view contents for the given view.
         *
         * @param  string|null  $view
         * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
         * @param  array  $mergeData
         * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
         */

        /**
         * compact() - Create array containing variables and their values
         * function compact($var_name, ...$var_names): array { }
         * @param mixed $var_name
         * @param mixed ...$var_names
         * @return array — the output array with all the variables added to it.
         *
         * compact() - takes a variable number of parameters.
         * Each parameter can be either a string containing the name of the variable, or an array of variable names.
         * The array can contain other arrays of variable names inside it; compact handles it recursively.
         *
         * Note: Any strings that does not match variable names will be skipped.
         */
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:tags|max:100',
        ]);

        /**
         * public function all($keys = null)
         *
         * Get all of the input and files for the request.
         *
         * @param  array|mixed|null  $keys
         * @return array
         */
        Tag::create($request->all());

        $request->session()->flash('success', 'Tag was added!!!');
        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dump($id);
        $tag = Tag::find($id);
        return view("admin.tags.edit", compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:categories|max:50',
        ]);

        $tag = Tag::find($id);
        // $category->slug = null;

        // The `update` method expects an array of column and value pairs
        // representing the columns that should be updated

        /**
         * public function all($keys = null)
         *
         * Get all of the input and files for the request.
         *
         * @param  array|mixed|null  $keys
         * @return array
         */
        $tag->update($request->all());

        // $request->session()->flash('success', 'Category was updated!!!');

        /**
         * public function with($key, $value = null)
         *
         * Flash a piece of data to the session.
         *
         * @param  string|array  $key
         * @param  mixed  $value
         * @return $this
         */
        return redirect()->route('tags.index')->with('success', 'Tag was updated!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Tag::find($id)->posts->count()) {
            return redirect()->route('tags.index')->with('error', 'Tag can NOT be deleted because it is asigned to the post(s)!!!');
        }

        Tag::destroy($id);
        /**
         * public function with($key, $value = null)
         *
         * Flash a piece of data to the session.
         *
         * @param  string|array  $key
         * @param  mixed  $value
         * @return $this
         */
        return redirect()->route('tags.index')->with('success', 'Tag was deleted!!!');
    }
}
