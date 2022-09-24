<?php

use DrH\TendePay\Http\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('/tendepay')
    ->name('tendepay.')
    ->group(function () {
        Route::post('/callback', [Controller::class, 'handleCallback'])->name('callback');
    });
