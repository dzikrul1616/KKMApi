<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesakitController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PesakitObatController;
use App\Http\Controllers\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::get('auth', 'index');
    Route::post('login', 'auth');
    Route::post('register', 'register');
    Route::post('send-otp', 'sendOTP');
    Route::post('verify-otp', 'verifyOTP');
});
Route::controller(PesakitController::class)->group(function () {
    Route::get('pesakit', 'index');
    Route::get('pesakit/{branch_id}', 'getPesakitId');
});
Route::controller(BranchController::class)->group(function () {
    Route::get('branch', 'index');
    Route::get('branch/{user_id}', 'getBranchId');
    Route::post('branch', 'addBranch');
});
Route::controller(PesakitObatController::class)->group(function () {
    Route::get('pesakitobat', 'index');
});
Route::controller(ObatController::class)->group(function () {
    Route::get('obat', 'index');
    Route::post('obat', 'addObat');
});