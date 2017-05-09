<?php

use GeneaLabs\LaravelImpersonator\Http\Controllers\ImpersonateeController;

Route::group(['middleware' => ['web', 'auth', 'can:impersonate,user']], function () {
    Route::resource('impersonatees', ImpersonateeController::class);
});
