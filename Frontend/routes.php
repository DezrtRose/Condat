<?php

Route::group(array('module' => 'Frontend', 'middleware' => ['guest'], 'namespace' => 'App\Modules\Frontend\Controllers'), function() {

    Route::get('register/agency', ['as' => 'frontend.agency', 'uses' => 'FrontendController@register']);
    Route::post('register/agency', 'FrontendController@store');

});	