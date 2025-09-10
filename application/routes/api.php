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
	Route::post('forgot/forgot_process_ajax', 'auth/Forgot@forgot_process_ajax');
	Route::post('forgot/recovery_process_ajax', 'auth/Forgot@recovery_process_ajax');
	Route::post('register/process_ajax', 'auth/Register@process_ajax');
});