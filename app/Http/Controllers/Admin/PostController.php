<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(3);

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
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         * vendor\laravel\framework\src\Illuminate\Support\Collection.php
         * public function pluck($value, $key = null)
         *
         * Get the values of a given key.
         *
         * @param  string|array  $value
         * @param  string|null  $key
         * @return \Illuminate\Support\Collection
         */

        /**
         * vendor\laravel\framework\src\Illuminate\Support\Collection.php
         * public function all()
         *
         * Get all of the items in the collection.
         *
         * @return array
         */

        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        //dd($tags);
        //dd(compact('categories', 'tags'));
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->hasFile('thumbnail'));
        //dd($request->file('thumbnail'));
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',
        ]);
        //return;

        $data = $request->all();
        /**
         * vendor\laravel\framework\src\Illuminate\Http\Concerns\InteractsWithInput.php
         * public function hasFile($key)
         *
         * Determine if the uploaded data contains a file.
         *
         * @param  string  $key
         * @return bool
         */
        if ($request->hasFile('thumbnail')) {
            $folder = date('Y-m-d');

            /**
             * vendor\laravel\framework\src\Illuminate\Http\UploadedFile.php
             * public function file($key = null, $default = null)
             *
             * Retrieve a file from the request.
             *
             * @param  string|null  $key
             * @param  mixed  $default
             * @return \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null
             */

            /**
             * vendor\laravel\framework\src\Illuminate\Http\UploadedFile.php
             * public function store($path, $options = [])
             *
             * Store the uploaded file on a filesystem disk.
             * The store method accepts the path where the file should be stored relative to the filesystem's configured root directory.
             * This path should not contain a file name, since a unique ID will automatically be generated to serve as the file name
             *
             * @param  string  $path
             * @param  array|string  $options
             * @return string|false
             */
            $path = $request->file('thumbnail')->store("images/{$folder}");
            //dump($path);
            $data['thumbnail'] = $path;
            //dump($data);
        }
        //dd($request->tags);

        $post = Post::create($data);

        /**
         * vendor\laravel\framework\src\Illuminate\Database\Eloquent\Relations\Concerns\InteractsWithPivotTable.php
         * public function sync($ids, $detaching = true)
         *
         * Sync the intermediate tables with a list of IDs or collection of models.
         *
         * @param  \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model|array  $ids
         * @param  bool  $detaching
         * @return array
         */
        $post->tags()->sync($request->tags);

        /**
         * vendor\laravel\framework\src\Illuminate\Routing\Redirector.php
         * public function route($route, $parameters = [], $status = 302, $headers = [])
         *
         * Create a new redirect response to a named route.
         *
         * @param  string  $route
         * @param  mixed  $parameters
         * @param  int  $status
         * @param  array  $headers
         * @return \Illuminate\Http\RedirectResponse
         */

        /**
         * vendor\laravel\framework\src\Illuminate\Http\RedirectResponse.php
         * public function with($key, $value = null)
         *
         * Flash a piece of data to the session.
         *
         * @param  string|array  $key
         * @param  mixed  $value
         * @return $this (\Illuminate\Http\RedirectResponse)
         */
        return redirect()->route('posts.index')->with('success', 'Post was added!!!');
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
