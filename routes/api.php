<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::controller(App\Http\Controllers\AuthController::class)->group(function () {
        Route::post('/cadastrar', 'register')->name('cadastrar');;
        Route::post('/login', 'login')->name('login');
    });

    Route::middleware(['auth:api'])->prefix('sistema')->group(function () {
        Route::controller(App\Http\Controllers\InfluenciadorController::class)->prefix('influencer')->group(function () {
            Route::get('/', 'index');
            Route::post('/criar', 'store');
        });
        Route::controller(App\Http\Controllers\CampanhasController::class)->prefix('campanhas')->group(function () {
            Route::get('/', 'index');
            Route::post('/criar', 'store');
            Route::post('/vincular-influenciadores/{id}', 'mask');
        });
    });
});