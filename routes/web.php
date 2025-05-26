<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


require __DIR__.'/auth.php';

Route::get('/', fn () => redirect()->route('posts.index'));

Route::resource('posts', PostController::class);
Route::post('posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');
Route::delete('comments/{comment}', [PostController::class, 'destroyComment'])->name('comments.destroy');
