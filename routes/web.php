<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Domains\Friend\Controllers\FriendController;
use App\Domains\User\Controllers\UserController;
use App\Domains\Channel\Controllers\ChannelController;
use App\Domains\Channel\Controllers\ChatController;
use App\Domains\Matching\Controllers\VideoChatMatchingController;
use App\Domains\Matching\Controllers\ChatMatchingController;
use App\Http\Controllers\VideoChatController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/home', function () {
    return Inertia::render('Home');
})->name('home');


Route::group(['prefix'=> 'video' ,'middleware'=>['auth:sanctum', 'verified']], function () {
    Route::get('/streaming', [VideoChatController::class, 'index'])->name('video.index');
});

Route::group(['prefix'=>'/matching/chat', 'middleware'=>['auth:sanctum', 'verified']], function () {
    Route::get('/', [ChatMatchingController::class, 'index'])->name('chat-match.index');
    Route::get('/connect/{genderType}', [ChatMatchingController::class, 'connect'])->name('chat-match.connect');
});
Route::group(['prefix'=>'/matching/videochat', 'middleware'=>['auth:sanctum', 'verified']], function () {
    Route::get('/', [VideoChatMatchingController::class, 'index'])->name('video-match.index');
    Route::get('/connect/{genderType}', [VideoChatMatchingController::class, 'connect'])->name('video-match.connect');
});

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












