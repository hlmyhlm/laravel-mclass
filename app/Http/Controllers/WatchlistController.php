<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;

class WatchlistController extends Controller
{
    public function __construct(protected TmdbService $tmdb) {}

    // Show full watchlist
    public function index()
    {
        $watchlist = auth()->user()->watchlist()->latest()->get();
        return view('watchlist.index', compact('watchlist'));
    }

    // Add a movie to watchlist
    public function store(int $movieId)
    {
        $movie       = $this->tmdb->getMovieDetails($movieId);
        $releaseYear = isset($movie['release_date'])
            ? (int) substr($movie['release_date'], 0, 4)
            : null;

        auth()->user()->watchlist()->firstOrCreate(
            ['movie_id' => $movieId],
            [
                'title'        => $movie['title'] ?? 'Unknown',
                'poster_path'  => $movie['poster_path'] ?? null,
                'vote_average' => $movie['vote_average'] ?? null,
                'release_year' => $releaseYear,
                'watched'      => false,
            ]
        );

        return back()->with('success', "'{$movie['title']}' added to Watchlist! 🕐");
    }

    // Remove a movie from watchlist
    public function destroy(int $movieId)
    {
        auth()->user()->watchlist()->where('movie_id', $movieId)->delete();
        return back()->with('success', 'Removed from Watchlist.');
    }
}
