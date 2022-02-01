<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        //dd($request->name);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);


        // $data = $request->session()->all();
        // return view('welcome', compact('data'));
        return redirect()->route('home')->with('success', 'User was registered!!!');
    }

    public function loginForm()
    {
        return view('user.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        /**
         * vendor\laravel\framework\src\Illuminate\Http\Concerns\InteractsWithInput.php
         *
         * public function only($keys)
         *
         * Get a subset containing the provided keys with values from the input data.
         *
         * @param  array|mixed  $keys
         * @return array
         */
        $credentials = $request->only('email', 'password');

        /**
         * Illuminate\Support\Facades\Auth::attempt
         *
         * public static function attempt($credentials = [], $remember = false) { }
         *
         * The attempt method accepts an array of key / value pairs as its first argument.
         * The values in the array will be used to find the user in your database table.
         * So, in the example above, the user will be retrieved by the value of the email column.
         * If the user is found, the hashed password stored in the database will be compared
         * with the password value passed to the method via the array.
         * You should not hash the password specified as the password value,
         * since the framework will automatically hash the value
         * before comparing it to the hashed password in the database.
         * If the two hashed passwords match an authenticated session will be started for the user.
         *
         * @param array $credentials
         * @param bool $remember
         *
         * @return bool
         * The attempt method will return true if authentication was successful.
         * Otherwise, false will be returned.
         */
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // dump($user->is_admin);
            // dd(session()->all());

            // Authentication passed...
            if ($user->is_admin) {
                return redirect()->route('admin.index');
                // return view('/admin/index', compact('user'));
            }
            return redirect()->route('home');
            //return view('welcome', compact('user'));
        }
        return redirect()->route('login.create')->with('logInError', 'Email or password is incorrect!');
    }

    public function logout()
    {
        /**
         * Illuminate\Support\Facades\Auth::logout
         *
         * public static function logout() { }
         *
         * To log users out of your application, you may use the logout method on the Auth facade.
         * This will clear the authentication information in the user's session.
         *
         * @return void
         */
        Auth::logout();
        return redirect()->route('home');
        // return view('user.login');
    }
}
