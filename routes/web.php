<?php

use App\Http\Controllers\ColocationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MemberShipController;
use App\Http\Controllers\ProfileController;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\MemberShip;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function (){
    Route::resource('colocations',ColocationController::class);

    Route::post('/colocations/{colocation}/invitations',[InvitationController::class,'store'])->name('invitations.store');
    Route::get('/colocations/{colocation}/invite',[InvitationController::class,'create'])->name('invitations.create');
    Route::get('/colocations/{colocation}/members',[MemberShipController::class,'index'])->name('invitations.index');
    Route::get('/invitations/{token}',[InvitationController::class,'show'])->middleware('auth')->name('invitations.show');
    Route::post('/invitations/{token}/accept',[InvitationController::class,'accept'])->name('invitations.accept');
    Route::post('/invitations/{token}/refuse',[InvitationController::class,'refuse'])->name('invitations.refuse');
    
    Route::post('/colocations/{colocation}/quit',[MemberShipController::class,'quit'])->name('colocations.quit');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    $stats = [
        'my_colocations' => \App\Models\Colocation::where('owner_id', $user->id)->count(),
        'active_colocations' => \App\Models\Colocation::where('owner_id', $user->id)->where('status','active')->count(),
        'joined_colocations' => \App\Models\MemberShip::where('user_id',$user->id)->whereNull('left_at')->count(),
        'pending_invitations' => \App\Models\Invitation::where('invited_email', $user->email)->where('status','pending')->count(),
    ];

    return view('dashboard', compact('stats'));
})->middleware(['auth', 'verified'])->name('dashboard');

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


require __DIR__.'/auth.php';
