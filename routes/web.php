<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\GlobalLeaderboard;

Route::get('/', function () {
    $competitions = \App\Models\Competition::where('status', 'active')
        ->where('end_date', '>=', now())
        ->with('creator')
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();    

    $stats = [
        'active_participants' => \App\Models\User::where('role', 'peserta')->count(),
        'qualifiers' => \App\Models\User::where('role', 'qualifier')->count(),
        'competitions' => \App\Models\Competition::count(),
    ];

    return view('welcome', compact('competitions', 'stats'));
});

Route::fallback(function () {
    return view('errors.404');
});

Route::get('/leaderboard', GlobalLeaderboard::class)->name('global.leaderboard');

//Auth
require __DIR__ . '/Auth.php';

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', \App\Livewire\UserProfile::class)->name('profile');
    //Admin
    require __DIR__ . '/Admin.php';
    //Peserta
    require __DIR__ . '/Peserta.php';
    //Qualifier
    require __DIR__ . '/Qualifier.php';
});