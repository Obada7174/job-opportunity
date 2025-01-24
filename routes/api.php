<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\SubmissionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('companies', CompanyController::class);
Route::resource('job-listings', JobListingController::class);
Route::resource('submissions', SubmissionController::class);