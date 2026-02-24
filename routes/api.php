<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('v1/books', [BookController::class, 'index']);
Route::post('v1/loans', [\App\Http\Controllers\LoanController::class, 'store']);
Route::post('v1/loans/{loan}/return', \App\Http\Controllers\ReturnLoanController::class);
