<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('voucher/generate', [VoucherCodeController::class, 'generate']);
    Route::get('voucher', [VoucherCodeController::class, 'index']);
    Route::delete('voucher/{id}', [VoucherCodeController::class, 'destroy']);
});
