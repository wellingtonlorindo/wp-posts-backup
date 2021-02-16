<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts', 'PostsController@index');

Route::patch('/post/{post}', 'PostsController@update')
    ->name('posts.update');

Route::get('/post/{post}/edit', 'PostsController@edit')
    ->name('posts.edit');

Route::get('/post/create', 'PostsController@create')
	->name('posts.create');

Route::get('/post/{post}', 'PostsController@show')
	->name('posts.show');

Route::post('/post', 'PostsController@store')
	->name('posts.store');

Route::delete('/post/{post}', 'PostsController@destroy')
	->name('posts.destroy');