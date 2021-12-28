<?php

use Illuminate\Support\Facades\Route;
use NagadApi\Base;
use NagadApi\Helper;

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
    ], function () {

    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::resource('post', 'PostController')->except(['show']);
    Route::resource('category', 'CategoryController')->except(['show']);
    Route::resource('tag', 'TagController')->except(['show']);
    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
});

Route::get('blog/view', function () {
    $data['blog'] = \App\Models\Post::orderBy('id','desc')->limit(1)->first();
    return view('welcome')->with($data);
});



