<?php

use GeneaLabs\LaravelImpersonator\Http\Controllers\ImpersonateeController;

app('router')->group(['middleware' => ['web', 'auth']], function () {
    app('router')->resource('impersonatees', ImpersonateeController::class);
});
