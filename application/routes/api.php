<?php

/**
 * API Routes
 *
 * This routes only will be available under AJAX requests. This is ideal to build APIs.
 */

# Auth
Route::group('auth', ['middleware' => ['AuthLogoutApi']], function()
{
	Route::post('login/process_ajax', 'auth/Login@process_ajax');
	Route::post('forgot/forgot_process_ajax', 'auth/Forgot@forgot_process_ajax');
	Route::post('forgot/recovery_process_ajax', 'auth/Forgot@recovery_process_ajax');
	Route::post('register/process_ajax', 'auth/Register@process_ajax');
	Route::post('activation/resend_process_ajax', 'auth/Activation@resend_process_ajax');
	Route::post('activation/activate_process_ajax', 'auth/Activation@activate_process_ajax');
});

# User
Route::group('user/settings', ['middleware' => ['AuthLoginApi']], function()
{
	Route::patch('ajax_change_email', 'user/Settings@ajax_change_email');
	Route::patch('ajax_change_password', 'user/Settings@ajax_change_password');
});