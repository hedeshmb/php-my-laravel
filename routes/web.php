<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/send-mail', [MailController::class, 'sendMail']);
