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
});


Route::prefix('admin')->namespace('Admin')->group(function () {
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

});
