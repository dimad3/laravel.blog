<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        /**
         * vendor\laravel\framework\src\Illuminate\Database\Eloquent\Model.php
         *
         * public static function with($relations)
         *
         * Begin querying a model with eager loading.
         *
         * @param  array|string  $relations
         * @return \Illuminate\Database\Eloquent\Builder
         */
        $posts = Post::with(['category', 'tags'])->paginate(10);

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
         *
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
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',
        ]);

        $data = $request->all();

        $data['thumbnail'] = Post::uploadImage($request);

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
        $post = Post::find($id);
        //dd(Category::all());
        //dd(Category::pluck('title', 'id')->all());
        $categories = Category::pluck('title', 'id')->all();
        $tags = Tag::pluck('title', 'id')->all();
        return view("admin.posts.edit", compact('post', 'categories', 'tags'));
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
            'title' => 'required|max:100',
            'description' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',
        ]);

        $post = Post::find($id);
        //dd($request->all());
        $data = $request->all();
        $data['thumbnail'] = Post::uploadImage($request, $post->thumbnail);

        $post->update($data);

        /**
         * vendor\laravel\framework\src\Illuminate\Database\Eloquent\Relations\Concerns\InteractsWithPivotTable.php
         *
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
         *
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
         *
         * public function with($key, $value = null)
         *
         * Flash a piece of data to the session.
         *
         * @param  string|array  $key
         * @param  mixed  $value
         * @return $this (\Illuminate\Http\RedirectResponse)
         */
        return redirect()->route('posts.index')->with('success', 'Post was updated!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        // dd(asset("uploads/{$post->thumbnail}"));
        $post->tags()->sync([]);
        //return;

        // https: //laravel.com/docs/7.x/filesystem#deleting-files
        Storage::delete($post->thumbnail);

        Post::destroy($id);
        /**
         * public function with($key, $value = null)
         *
         * Flash a piece of data to the session.
         *
         * @param  string|array  $key
         * @param  mixed  $value
         * @return $this
         */
        return redirect()->route('posts.index')->with('success', "Post [id = {$id}] was deleted!!!");
    }
}
