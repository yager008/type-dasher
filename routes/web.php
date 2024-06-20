<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeTestController;
use App\Http\Controllers\BibleApiController;
use App\Http\Controllers\LoremApiController;
use Illuminate\Support\Str;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profileDelete', [ProfileController::class, 'reset'])->name('profile.reset');

    Route::get('/dashboard', [TypeTestController::class, 'type' ])->name('TypeTestController.type');
    Route::get('/statistics', [TypeTestController::class, 'statistics' ])->name('TypeTestController.statistics');
    Route::get('/savedTexts', [TypeTestController::class, 'savedTexts' ])->name('TypeTestController.savedTexts');



    Route::get('/Bible', [TypeTestController::class, 'bible' ])->name('typeTest.bible');
    Route::get('/Lorem', [TypeTestController::class, 'lorem' ])->name('typeTest.lorem');

    Route::post('/dashboard', [TypeTestController::class, 'type' ])->name('TypeTestControllerPost.type');
    Route::post('/StoreResult', [TypeTestController::class, 'storeResult' ])->name('TypeTestController.store');
    Route::post('/openSavedText', [TypeTestController::class, 'openSavedText' ])->name('TypeTestController.openSavedText');
    Route::post('/exitSavedTextMode', [TypeTestController::class, 'exitSavedTextMode' ])->name('TypeTestController.exitSavedTextMode');

    Route::get('/StoreSavedText', [TypeTestController::class, 'storeSavedTextIfCheckboxIsOn' ])->name('TypeTestController.storeSavedTextIfCheckBoxIsOn');
    Route::post('/StoreSavedText', [TypeTestController::class, 'storeSavedTextIfCheckboxIsOn' ])->name('TypeTestControllerPost.storeSavedTextIfCheckBoxIsOn');
    Route::post('/DeleteSavedText', [TypeTestController::class, 'deleteSavedText' ])->name('TypeTestControllerPost.deleteSavedText');
    Route::post('/createText', [TypeTestController::class, 'createText' ])->name('TypeTestControllerPost.createText');

    Route::get('/BibleApiRequest', [BibleApiController::class, 'index' ])->name('BibleApiController.index');
    Route::post('/BibleApiRequest', [BibleApiController::class, 'index' ])->name('BibleApiControllerPost.index');

    Route::get('/LoremApiRequest', [LoremApiController::class, 'index' ])->name('LoremApiController.index');
    Route::post('/LoremApiRequest', [LoremApiController::class, 'index' ])->name('LoremApiControllerPost.index');
});

Route::fallback(function () {
    return redirect('/');
});


// Password Reset Link Request Routes...
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');

// Password Reset Routes...
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.update');

Route::get('/send-test-email', function () {
    \Illuminate\Support\Facades\Mail::raw('This is a test email!', function ($message) {
        $message->to('test@example.com')
            ->subject('Test Email');
    });
    return 'Test email sent!';
});

require __DIR__.'/auth.php';
