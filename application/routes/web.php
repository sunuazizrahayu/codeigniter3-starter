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

# Sample
Route::group('sample', function()
{
	Route::group('layouts', function()
	{
		Route::get('/{any:slug1?}/{any:slug2?}', 'sample/Layouts@$1/$2');
		Route::get('/', 'sample/Layouts@index');
	});
	Route::group('message', function()
	{
		Route::get('/', 'sample/Message@index');
		Route::post('/', 'sample/Message@index');
	});
	Route::group('upload', function()
	{
		Route::get('/', 'sample/Upload@index');
		Route::post('/', 'sample/Upload@index');
	});
});

# DB migration
Route::get('webhook/migrate', 'webhook/Migrate@index');