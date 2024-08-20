<?php

use Illuminate\Support\Facades\Route;
use Alves\Pix\Http\Controllers\PixController;

Route::get('laravel-psp-pix/pix/create', [PixController::class, 'create'])
    ->name('laravel-psp-pix.qr-code.create')
    ->middleware(config('laravel-psp-pix.create_qr_code_route_middleware'));
