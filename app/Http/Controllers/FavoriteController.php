<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;

class FavoriteController extends Controller
{
    public function __construct(protected TmdbService $tmdb) {}

    // Show all favorites
    public function index()
    {
        $favorites = auth()->user()->favorites()->latest()->get();
        return view('favorites.index', compact('favorites'));
    }

    // Add a movie to favorites
    public function store(int $movieId)
    {
        $movie       = $this->tmdb->getMovieDetails($movieId);
        $releaseYear = isset($movie['release_date'])
            ? (int) substr($movie['release_date'], 0, 4)
            : null;

        auth()->user()->favorites()->firstOrCreate(
            ['movie_id' => $movieId],
            [
                'title'        => $movie['title'] ?? 'Unknown',
                'poster_path'  => $movie['poster_path'] ?? null,
                'vote_average' => $movie['vote_average'] ?? null,
                'release_year' => $releaseYear,
            ]
        );

        return back()->with('success', "'{$movie['title']}' added to Favorites! ❤️");
    }

    // Remove a movie from favorites
    public function destroy(int $movieId)
    {
        auth()->user()->favorites()->where('movie_id', $movieId)->delete();
        return back()->with('success', 'Removed from Favorites.');
    }
}
