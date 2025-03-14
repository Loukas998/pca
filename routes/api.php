<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeProjectController;

Route::controller(StoryController::class)->group(function() {
    Route::post('stories', 'store');
    Route::get('stories', 'index');
    Route::get('stories/{id}', 'show');
    Route::put('stories/{id}', 'update');
    Route::delete('stories/{id}', 'destroy');
});

Route::controller(CategoryController::class)->group(function() {
    Route::post('categories', 'store');
    Route::get('categories', 'index');
    Route::get('categories/{id}', 'show');
    Route::put('categories/{id}', 'update');
    Route::delete('categories/{id}', 'destroy');
});

Route::controller(ProjectController::class)->group(function() {
    Route::post('projects', 'store');
    Route::get('projects', 'index');
    Route::get('projects/{id}', 'show');
    Route::put('projects/{id}', 'update');
    Route::delete('projects/{id}', 'destroy');
});

Route::controller(ContactUsController::class)->group(function() {
    Route::post('contact-us', 'store');
    Route::get('contact-us', 'index');
    Route::get('contact-us/{id}', 'show');
    Route::put('contact-us/{id}', 'update');
    Route::delete('contact-us/{id}', 'destroy');
});

Route::controller(HomeProjectController::class)->group(function() {
    Route::post('home-projects', 'store');
    Route::get('home-projects', 'index');
    Route::get('home-projects/{id}', 'show');
    Route::put('home-projects/{id}', 'update');
    Route::delete('home-projects/{id}', 'destroy');
});