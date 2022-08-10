<?php

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Auth::routes();


/**
 * Admin Panel Routes
 */

Route::group(
    [
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'as' => 'admin.',
        'middleware' => 'auth',
    ], static function () {

    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::resource('post', 'PostController')->except(['show']);
    Route::resource('category', 'CategoryController')->except(['show']);
    Route::resource('tag', 'TagController')->except(['show']);
    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
});

Route::get('blog/view', function () {
    $data['blog'] = Post::orderBy('id', 'desc')->limit(1)->first();
    return view('welcome')->with($data);
});



