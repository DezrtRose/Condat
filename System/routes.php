<?php

Route::group(array('module' => 'System', 'middleware' => ['auth'], 'namespace' => 'App\Modules\System\Controllers'), function() {

    Route::resource('setting', 'SystemController');
    Route::get('settings/subscription', 'SubscriptionController@index');
    Route::post('settings/subscription', 'SubscriptionController@update');
    Route::get('settings/email', 'EmailController@index');
    Route::post('settings/email', 'EmailController@update');
    Route::get('settings/templates', 'EmailController@template');
    Route::post('settings/templates', 'EmailController@updateTemplate');
});