<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\GamificationController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('decks', DeckController::class);
    
    Route::post('/decks/{deck}/cards', [CardController::class, 'store'])->name('cards.store');
    Route::put('/cards/{card}', [CardController::class, 'update'])->name('cards.update');
    Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');
    
    Route::get('/study/{deck}', [StudyController::class, 'index'])->name('study.index');
    Route::get('/study/{deck}/cards', [StudyController::class, 'nextCards'])->name('study.nextCards');
    Route::post('/study/{deck}/answer', [StudyController::class, 'answer'])->name('study.answer');
    
    Route::get('/leaderboard', [GamificationController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/achievements', [GamificationController::class, 'achievements'])->name('achievements');
    Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');
});

Route::get('/u/{user}', [ProfileController::class, 'show'])->name('profile.show');

require __DIR__.'/auth.php';
