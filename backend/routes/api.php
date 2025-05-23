<?php

use App\Events\sendMessage;
use App\Models\User;
use App\Models\JobOffer;
use App\Events\TestEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::group(['middleware' => 'auth:sanctum'], function () { //,admin,company
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('/user', function (Request $request) {
        $user = $request->user();

        if ($user->tokenCan('user')) {
            $type = 'user';
        } elseif ($user->tokenCan('company')) {
            $type = 'company';
        } elseif ($user->tokenCan('admin')) {
            $type = 'admin';
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'user' => $user,
            'type' => $type,
        ]);
    });
    // routes to serve images 
    Route::get('/images/{userId}.jpg', function ($userId) {
        $path = public_path("images/{$userId}.jpg");
        return response()->file($path);
    })->where('userId', '[0-9]+');
    Route::get('/images/other/{str}.png', function ($str) {
        $path = public_path("images/other/{$str}.png");
        return response()->file($path);
    });
    // fetch contacts
    Route::post('/chat/contacts', [ChatController::class, 'fetchContacts']);
    Route::post('/chat/send-message', [ChatController::class, 'chatmessage']);


    Route::post('/broadcast', function (Request $request) {
        $validated_data = $request->validate([
            'message' => 'required|string',
        ]);

        broadcast(new sendMessage(
            $validated_data['message'],
            $request->user()->id,
            $request->user()->first_name,
            1
        ));
    });
});
Broadcast::routes(['middleware' => ['auth:sanctum']]);
