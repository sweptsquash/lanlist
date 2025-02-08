<?php

use App\Http\Controllers\Account\AccountConnectionsController;
use App\Http\Controllers\Account\AccountDetailController;
use App\Http\Controllers\Account\AccountSecurityController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\DiscordAuthController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwitchAuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->name('auth.')->group(function () {
    Route::prefix('login')->controller(AuthenticatedSessionController::class)->group(function () {
        Route::get('', 'create')->name('login');
        Route::post('', 'store');
    });

    Route::prefix('forgot-password')->controller(PasswordResetLinkController::class)->group(function () {
        Route::get('', 'create')->name('password.request');
        Route::post('', 'store')->name('password.email');
    });

    Route::prefix('reset-password')->controller(NewPasswordController::class)->group(function () {
        Route::get('{token}', 'create')->name('password.reset');
        Route::post('', 'store')->name('password.update');
    });

    Route::prefix('register')->controller(RegisteredUserController::class)->group(function () {
        Route::get('', 'create')->name('register');
        Route::post('', 'store');
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('verify-email')->group(function () {
        Route::get('', EmailVerificationPromptController::class)->name('verification.notice');
        Route::get('{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
    });

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::prefix('confirm-password')->controller(ConfirmablePasswordController::class)->group(function () {
        Route::get('', 'show')->name('password.confirm');
        Route::post('', 'store');
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::prefix('discord')->name('discord.')->controller(DiscordAuthController::class)->group(function () {
        Route::get('redirect', 'index')->name('redirect');
        Route::get('callback', 'store')->name('callback');
    });

    Route::prefix('twitch')->name('twitch.')->controller(TwitchAuthController::class)->group(function () {
        Route::get('redirect', 'index')->name('redirect');
        Route::get('callback', 'store')->name('callback');
    });
});

Route::middleware('auth')->prefix('account')->name('account.')->controller(AccountDetailController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::put('', 'update')->name('update');

    Route::prefix('security')->name('security.')->controller(AccountSecurityController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::put('', 'update')->name('update');
    });

    Route::prefix('connections')->name('connections.')->controller(AccountConnectionsController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::delete('', 'destroy')->name('destroy');
    });
});
