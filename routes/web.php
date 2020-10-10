<?php

use GeneaLabs\LaravelImpersonator\Http\Controllers\ImpersonateeController;

app('router')->resource('impersonatees', ImpersonateeController::class);
