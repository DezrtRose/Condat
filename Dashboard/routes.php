<?php

Route::group(array('module' => 'Dashboard', 'namespace' => 'App\Modules\Dashboard\Controllers', 'middleware' => ['auth']), function() {

    Route::get('dashboard', 'DashboardController@index');
    Route::get('dashboard/newAgencyData', 'DashboardController@getNewAgencyData');
    Route::get('dashboard/expiringAgencyData', 'DashboardController@getExpiringAgencyData');

});	