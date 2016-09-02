<?php

Route::group(array('module' => 'Auth', 'middleware' => ['guest'], 'namespace' => 'App\Modules\Auth\Controllers'), function() {

    // Authentication routes
    Route::get('login', 'AuthController@getLogin');
    Route::post('login', 'AuthController@postLogin');

    // Registration routes
    Route::get('register', 'AuthController@getRegister');
    Route::post('register', 'AuthController@postRegister');

    // Forgot Password Routes
    Route::get('forgot-password', 'PasswordController@getForgotPassword');
    Route::post('forgot-password', 'PasswordController@postForgotPassword');
    Route::get('reset-password/{code}', ['as' => 'system.reminders.getReset', 'uses' => 'PasswordController@getReset']);
    Route::post('reset-password/{code}', ['as' => 'system.reminders.postReset', 'uses' => 'PasswordController@postReset']);

});

Route::group(array('module' => 'Auth', 'middleware' => ['auth'], 'namespace' => 'App\Modules\Auth\Controllers'), function() {
    Route::get('logout', 'AuthController@logout');
});
