<?php

/**
 * API Routes
 *
 * This routes only will be available under AJAX requests. This is ideal to build APIs.
 */

# auth
Route::group('auth', function()
{
	Route::post('login/process_ajax', 'auth/Login@process_ajax');
});