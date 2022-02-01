<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::prefix('admin')->namespace('Admin')->middleware('admin')->group(function () {
    // Matches The "/admin/users" URL
    // Controllers Within The "App\Http\Controllers\Admin" Namespace

    // https://laravel.com/api/7.x/Illuminate/Routing/Router.html#method_get
    // https://github.com/laravel/framework/blob/7.x/src/Illuminate/Routing/Router.php#L143
    /**
     * Register a new GET route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return \Illuminate\Routing\Route
     *
     * public function get($uri, $action = null)
     */
    Route::get('/', 'MainController@index')->name('admin.index');

    /**
     *
     * @param  string  $name - base incoming request URI
     * @param  string  $controller - class name of the controller which is used to handle the request
     *
     * \Illuminate\Routing\PendingResourceRegistration resource(string $name, string $controller, array $options = [])
     */
    Route::resource('categories', 'CategoryController');
    Route::resource('tags', 'TagController');
    Route::resource('posts', 'PostController');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', 'UserController@create')->name('register.create');
    Route::post('/register', 'UserController@store')->name('register.store');
    Route::get('/login', 'UserController@loginForm')->name('login.create');
    Route::post('/login', 'UserController@login')->name('login');
});

Route::get('/logout', 'UserController@logout')->name('logout')->middleware('auth');
