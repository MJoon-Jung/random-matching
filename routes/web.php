<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Domains\Friend\Controllers\FriendController;
use App\Domains\User\Controllers\UserController;
use App\Domains\Channel\Controllers\ChannelController;
use App\Domains\Channel\Controllers\ChatController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['prefix'=>'users', 'middleware'=>['auth:sanctum', 'verified']], function () {
   Route::get('/notification', [UserController::class, 'getNotification'])->name('user.notification');
   Route::get('/search', [UserController::class, 'searchUser'])->name('user.search');
   Route::get('/friends', [FriendController::class, 'index'])->name('friend.index');
   Route::get('/friends/{user}/notifications', [FriendController::class, 'request'])->name('friend.request');
   Route::patch('/notification', function () {
       Auth::user()->unreadNotifications->markAsRead();
       return response()->json(["message"=>"success"]);
   })->name('user.read');
   Route::patch('/friends/{user}', [FriendController::class, 'receive'])->name('friend.receive');
});

Route::group(['prefix'=>'channels', 'middleware'=>['auth:sanctum', 'verified']], function () {
    Route::get('/', [ChannelController::class, 'index'])->name('channel.index');
    Route::get('/{channel}/chats', [ChannelController::class, 'loadChat'])->name('channel.loadChat');
    Route::patch('/{channel}', [ChannelController::class, 'participate'])->name('channel.participate');
    Route::post('/{channel}', [ChatController::class, 'store'])->name('chat.store');
});












