<?php

use App\Events\MessageSendEvent;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $users = User::where('id', '!=',  Auth::user()->id)->get();

    return view('dashboard',['users'=>$users]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/chat/{id}', function ($id) {
//     $users = User::where('id', '!=',  Auth::user()->id)->get();
//     return view('chat', ['users' => $users, 'id' => $id]);
// })->middleware(['auth', 'verified'])->name('chat');
// Route::get('/chat/{id}', function ($id) {
//     return app(ChatController::class)->mount($id);
// })->middleware(['auth', 'verified'])->name('chat');
Route::get('/chat/{id}', [ChatController::class, 'show'])->middleware(['auth', 'verified'])->name('chat');
Route::post('/chat/send-message', [ChatController::class, 'sendMessage'])->name('send-message');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
