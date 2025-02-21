<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PostsController::class, 'welcome'])->name('welcome');

// Route::resource('categories', CategoryController::class);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::post('/categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('/categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
Route::get('/categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/posts/{post}/like', [PostsController::class, 'like'])->name('posts.like');
Route::delete('/posts/{post}/unlike', [PostsController::class, 'unlike'])->name('posts.unlike');

Route::get('/posts/{id}/show', [PostsController::class, 'show'])->name('posts.show');
Route::get('/posts/trashed', [PostsController::class, 'trashed'])->name('posts.trashed');
Route::get('/posts/{id}/restore', [PostsController::class, 'restore'])->name('posts.restore');
Route::delete('/posts/{id}/force-delete', [PostsController::class, 'forceDelete'])->name('posts.forceDelete');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostsController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
