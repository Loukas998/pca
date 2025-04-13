<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeProjectController;

Route::controller(StoryController::class)->group(function () {
    Route::post('stories', 'store')->middleware('auth:sanctum');
    Route::get('stories', 'index');
    Route::get('stories/{id}', 'show');
    Route::put('stories/{story}', 'update')->middleware('auth:sanctum');
    Route::delete('stories/{story}', 'destroy')->middleware('auth:sanctum');
    Route::post('stories/{story}/replace-image', 'replaceImage')->middleware('auth:sanctum');
});

Route::controller(CategoryController::class)->group(function () {
    Route::post('categories', 'store')->middleware('auth:sanctum');
    Route::get('categories', 'index');
    Route::get('categories/{id}', 'show');
    Route::put('categories/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('categories/{id}', 'destroy')->middleware('auth:sanctum');
});

Route::prefix('projects')->controller(ProjectController::class)->group(function () {
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('/{id}', 'destroy')->middleware('auth:sanctum');
    Route::post('/{project}/replace-image', 'replaceImage')->middleware("auth:sanctum");
});

Route::controller(ContactUsController::class)->group(function () {
    Route::post('contact-us', 'store');
    Route::get('contact-us', 'index');
    Route::get('contact-us/{id}', 'show');
    Route::put('contact-us/{id}', 'update');
    Route::delete('contact-us/{id}', 'destroy')->middleware('auth:sanctum');
});

Route::prefix('home-projects')->controller(HomeProjectController::class)->group(function () {
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update')->middleware('auth:sanctum');
    Route::delete('/{id}', 'destroy')->middleware('auth:sanctum');
    Route::post('/reorder', 'reorder')->middleware('auth:sanctum');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::get('logout', 'logout')->middleware('auth:sanctum');
});
