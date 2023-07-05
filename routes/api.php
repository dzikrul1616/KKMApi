<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesakitController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PesakitObatController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\SpecialistController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::get('auth', 'index');
    Route::post('send-notification', 'sendNotification');
    Route::post('login', 'auth');
    Route::post('register', 'register');
    Route::post('send-otp', 'sendOTP');
    Route::post('verify-otp', 'verifyOTP');
});
Route::controller(RumahSakitController::class)->group(function () {
    Route::get('rumah-sakit', 'index');
});
Route::controller(SpecialistController::class)->group(function () {
    Route::get('specialist', 'index');
});
Route::controller(CheckController::class)->group(function () {
    Route::get('check', 'checkAuthStatus');
    Route::post('register-data', 'registerData');
    Route::delete('logout', 'logout');
});
Route::controller(PesakitController::class)->group(function () {
    Route::get('pesakit', 'index');
    Route::get('pesakit/{branch_id}', 'getPesakitId');
    Route::post('pesakit', 'addPesakit');
    Route::delete('pesakit/{pesakit_id}', 'deletePesakit');
});
Route::controller(BranchController::class)->group(function () {
    Route::get('branch', 'index');
    Route::get('branchid', 'getBranchId');
    Route::post('branch', 'addBranch');
    Route::delete('branch/{id}', 'deleteBranch');
});
Route::controller(PesakitObatController::class)->group(function () {
    Route::get('pesakitobat', 'index');
});
Route::controller(ObatController::class)->group(function () {
    Route::get('obat', 'index');
    Route::post('obat', 'addObat');
    Route::delete('obat/{id}', 'deleteObat');
});