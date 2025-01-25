<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SkillController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';










Route::resource('users', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('companies', CompanyController::class);
Route::resource('job-listings', JobListingController::class);
Route::resource('submissions', SubmissionController::class);
//تعديل المستخدم
Route::post('users/{id}',[UserController::class,'updateUser']);
//تعديل الcategory
Route::post('categories/{id}',[CategoryController::class,'updateCategory']);
//تعديل الcompany
Route::post('companies/{id}',[CompanyController::class,'updateCompany']);
//تعديل الjob
Route::post('job-listings/{id}',[JobListingController::class,'updateJob']);
//تعديل الsubmissions
Route::post('submissions/{id}',[submissionController::class,'updateSubmission']);

//عرض مهارات المستخدم الواحد
Route::get('/users/{userId}/skills', [UserController::class, 'getUserSkills']);
//بحث عن مهارة
Route::get('skill/search',[SkillController::class,'search']);
// إضافة مهارة إلى المستخدم
Route::post('/users/{userId}/skills', [UserController::class, 'addSkill']);

// إزالة مهارة من المستخدم
Route::delete('/users/{userId}/skills', [UserController::class, 'removeSkill']);
