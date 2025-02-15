<?php

use App\Livewire\PostForm;
use App\Livewire\PostList;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/',  PostList::class)->name('posts');
Route::get('/posts/create',  PostForm::class)->name('posts.create');
Route::get('/posts.view/{post}',  PostForm::class)->name('posts.view');
Route::get('/posts.edit/{post}',  PostForm::class)->name('posts.edit');
 