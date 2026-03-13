<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\WatchlistController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

// ── Home: redirect to movies ───────────────────────────────────────────────
Route::get('/', [MovieController::class, 'index'])->name('movies.index');

// ── Movie Routes (public — anyone can browse) ──────────────────────────────
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movies/genre/{id}', [MovieController::class, 'byGenre'])->name('movies.genre');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

// ── Dashboard ──────────────────────────────────────────────────────────────
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ── Auth-Protected Routes ──────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{movieId}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{movieId}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Watchlist
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/watchlist/{movieId}', [WatchlistController::class, 'store'])->name('watchlist.store');
    Route::delete('/watchlist/{movieId}', [WatchlistController::class, 'destroy'])->name('watchlist.destroy');

    // Admin-only routes
    Route::middleware(IsAdminMiddleware::class)->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('posts', PostController::class);
    });

});

require __DIR__ . '/auth.php';
