<?php



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::group(['prefix' => 'dashboard','middleware'=>'auth'], function () {

            Route::get('/', 'DashboardController@index')->name('dashboard.index');
            Route::resource('users','UsersController');

        });

    });

