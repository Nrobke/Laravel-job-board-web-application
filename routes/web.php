<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MyJobApplicationController;
use App\Http\Controllers\MyJobController;
use App\Http\Middleware\Employer as MiddlewareEmployer;
use App\Jobs\TranslateJob;
use App\Mail\JobPosted;
use App\Models\Employer;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('', fn() => to_route('jobs.index'));
Route::resource('jobs', JobController::class)->only(['index', 'show']);

Route::get('test', function(){
    $job = Job::first();
    TranslateJob::dispatch($job);

    return 'Done';
});

Route::get('login', fn() => to_route('auth.create'))->name('login');
Route::resource('auth', AuthController::class)
    ->only(['create', 'store']);

Route::delete('logout', fn() => to_route('auth.destroy'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])
    ->name('auth.destroy');

Route::middleware('auth')->group((function(){
    Route::resource('job.application', JobApplicationController::class)
        ->only(['create', 'store']);
    Route::resource('my-job-applications', MyJobApplicationController::class)
        ->only(['index', 'destroy']);
    Route::resource('employer', EmployerController::class)
        ->only(['create', 'store']);
    Route::middleware(MiddlewareEmployer::class)->resource('my-jobs', MyJobController::class);
}));
