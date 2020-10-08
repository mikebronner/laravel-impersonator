<?php

use GeneaLabs\LaravelImpersonator\Http\Controllers\ImpersonateeController;

app('router')->group(['middleware' => config('genealabs-laravel-impersonator.middleware', ['web', 'auth'])], function () {
    app('router')->resource('impersonatees', ImpersonateeController::class);
});
