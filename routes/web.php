<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\MessageController;



Route::get('/test', [TestController::class, 'index']);

// Home route
Route::get('/home', [CategoryController::class, 'index'])->name('home');

// Publicly accessible routes
Route::get('/users/{user}', [ProfileController::class, 'show'])->name('users.show');

// Authentication routes (Login, Register, etc.)
require __DIR__.'/auth.php';

// Routes protected by 'auth' middleware
Route::middleware('auth')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('home');

    Route::resource('discussions.posts', PostController::class)->only(['store']);

    Route::resource('discussions', DiscussionController::class);

    // Nested resource routes for posts within discussions
    Route::resource('discussions.posts', PostController::class)->only(['store', 'destroy']);

    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Categories
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');


    Route::get('/discussions/search', [DiscussionController::class, 'search'])->name('discussions.search');
    // Discussions CRUD
    Route::get('/discussions/{discussion}', [DiscussionController::class, 'show'])->name('discussions.show');

    Route::get('/discussions/create', [DiscussionController::class, 'create'])->name('discussions.create')->middleware('auth');
    
    Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');

    Route::get('/discussions/{discussion}/edit', [DiscussionController::class, 'edit'])->name('discussions.edit');

    Route::put('/discussions/{discussion}', [DiscussionController::class, 'update'])->name('discussions.update');

    Route::delete('/discussions/{discussion}', [DiscussionController::class, 'destroy'])->name('discussions.destroy');

    // Profile edit and update
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

     // Post routes
       // Route to show form for creating a new post
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
     // Route to store a new post
     Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
     Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
     Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
     Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});



// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
//     Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
//     Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
//     Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

//     Route::delete('/admin/discussions/{discussion}', [AdminController::class, 'deleteDiscussion'])->name('admin.discussions.destroy');
//     Route::delete('/admin/comments/{comment}', [AdminController::class, 'deleteComment'])->name('admin.comments.destroy');
// });

Route::middleware(['auth', 'admin'])->group(function () {
    // Route::get('/home', function () {
    //     if (auth()->check() && auth()->user()->is_admin) {
    //         return redirect()->route('admin.home.index');
    //     }
    //     return view('home'); 
    // })->name('home');
    // Route::get('/admin/home', [CategoryController::class, 'adminHome'])->name('admin.home.index');
    Route::get('/admin/home', [CategoryController::class, 'adminHome'])->name('admin.home.index');

    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

    // New route for admin discussions management
    Route::get('/admin/discussions', [AdminController::class, 'manageDiscussions'])->name('admin.discussions.index');

    Route::delete('/admin/discussions/{discussion}', [AdminController::class, 'deleteDiscussion'])->name('admin.discussions.destroy');
    Route::delete('/admin/comments/{comment}', [AdminController::class, 'deleteComment'])->name('admin.comments.destroy');

    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});