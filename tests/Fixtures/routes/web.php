<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use GeneaLabs\LaravelImpersonator\Tests\Fixtures\App\Http\Controllers\HomeController;

Route::group(["middleware" => ["web"]], function () {
    Auth::routes();
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
