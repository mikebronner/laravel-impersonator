<?php

app('router')->middleware('web')
    ->group(function () {
        Auth::routes();
        Route::get('/home', 'HomeController@index')->name('home');
    });
