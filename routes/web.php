<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VoucherCodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('voucher/generate', [VoucherCodeController::class, 'generate']);
    Route::get('voucher', [VoucherCodeController::class, 'index']);
    Route::delete('voucher/{id}', [VoucherCodeController::class, 'destroy']);
});