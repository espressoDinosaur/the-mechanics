<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Google Login
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Facebook Login
Route::get('login/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Administrator
Route::post('/create-post', [PostController::class, 'store'])->name('create-post');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{id}', [PostController::class, 'deletePost'])->name('posts.delete');
// Registered User
Route::post('/post/{postId}/comment', [PostController::class, 'storeComment'])->name('post.comment');
Route::post('/posts/{post}/gear', [PostController::class, 'gearPost'])->name('posts.gear')->middleware('auth');

Route::post('/filter-posts', [PostController::class, 'filterPosts'])->name('posts.filter');