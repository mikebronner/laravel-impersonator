<?php

use GeneaLabs\LaravelImpersonator\Http\Controllers\ImpersonateeController;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('impersonatees', ImpersonateeController::class);
});
