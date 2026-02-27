<?php

use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function (){
    Route::resource('colocations',ColocationController::class);

    Route::post('/colocations/{colocation}/invitations',[InvitationController::class,'store'])->name('invitations.store');
    Route::post('/invitations/{token}',[InvitationController::class,'show'])->name('invitations.show');
    Route::post('/invitations/{token}/accept',[InvitationController::class,'accept'])->name('invitations.accept');
    Route::post('/invitations/{token}/refuse',[InvitationController::class,'refuse'])->name('invitations.refuse');
});

Route::get('/dashboard', function () {
    // if(Auth::user()->role === 'admin'){
    //     redirect()->route('dashboard');
    // }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

Route::get('/invitations/{token}',[InvitationController::class,'show'])->middleware('auth')->name('invitations.show');

require __DIR__.'/auth.php';
