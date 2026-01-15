<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/projects', [PortfolioController::class, 'index'])->name('projects');
Route::get('/project/{slug}', [PortfolioController::class, 'show'])->name('project.show');
Route::get('/about', [PortfolioController::class, 'about'])->name('about');

Route::prefix('console')->name('admin.')->group(function () {
    Route::get('/access', [AuthController::class, 'create'])->name('login');
    Route::post('/access', [AuthController::class, 'store'])->name('login.store');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');
        
        // Projects routes
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/archived', [ProjectController::class, 'archived'])->name('projects.archived');
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::post('/projects/{project}/archive', [ProjectController::class, 'archive'])->name('projects.archive');
        Route::post('/projects/{project}/unarchive', [ProjectController::class, 'unarchive'])->name('projects.unarchive');
        Route::post('/projects/{project}/delete-image', [ProjectController::class, 'deleteImage'])->name('projects.deleteImage');
        Route::post('/upload-image', [UploadController::class, 'uploadImage'])->name('uploadImage');
    });
});
