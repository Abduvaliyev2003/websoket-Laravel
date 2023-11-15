<?php

use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\UserController;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/chats', [ChatsController::class, 'index'])->name('chat');
Route::get('messages/{id}/user/{user_id}', [ChatsController::class,'fetchMessages']);
Route::post('messages', [ChatsController::class,'sendMessage']);
Route::get('conver', [ConversationController::class, 'chatlist'])->name('cons');
Route::get('convert/{id}', [ConversationController::class, 'create'])->name('convert');
Route::post('edit', [ChatsController::class,'updateMessage'])->name('edit');
Route::get('/users', [UserController::class, 'index'])->name('user');
Route::put('user/online/{id}', [UserController::class, 'userOnline'])->name('userOnline');
Route::put('user/onffline/{id}', [UserController::class, 'userOnffline'])->name('userOnffline');