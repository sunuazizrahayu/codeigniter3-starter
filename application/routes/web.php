<?php

/**
 * Welcome to Luthier-CI!
 *
 * This is your main route file. Put all your HTTP-Based routes here using the static
 * Route class methods
 *
 * Examples:
 *
 *    Route::get('foo', 'bar@baz');
 *      -> $route['foo']['GET'] = 'bar/baz';
 *
 *    Route::post('bar', 'baz@fobie', [ 'namespace' => 'cats' ]);
 *      -> $route['bar']['POST'] = 'cats/baz/foobie';
 *
 *    Route::get('blog/{slug}', 'blog@post');
 *      -> $route['blog/(:any)'] = 'blog/post/$1'
 */

Route::get('/', 'Welcome@index');
Route::set('404_override', '');
Route::set('translate_uri_dashes', FALSE);

# DB migration
Route::get('webhook/migrate', 'webhook/Migrate@index');

# sample layouts
Route::get('sample/layouts/', 'sample/Layouts@index');
Route::get('sample/layouts/(.*)', 'sample/Layouts@$1');

# Auth
Route::get('auth', 'auth/Home@index');
Route::get('login', 'auth/Login@index');
Route::get('logout', 'auth/Logout@index');
Route::get('forgot', 'auth/Forgot@index');
Route::group('auth', function()
{
	Route::get('forgot/recovery/(:any)/(:any)', 'auth/Forgot@recovery/$1/$2');
});