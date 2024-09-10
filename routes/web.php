<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VoucherCodeController;

Route::get('/', function () {
    return view('welcome');
});