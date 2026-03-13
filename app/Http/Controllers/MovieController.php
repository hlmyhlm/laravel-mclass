<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(protected TmdbService $tmdb) {}

    // Home page — trending + popular + genres
    public function index()
    {
        $trending = $this->tmdb->getTrendingMovies();
        $popular  = $this->tmdb->getPopularMovies();
        $genres   = $this->tmdb->getGenres();

        return view('movies.index', compact('trending', 'popular', 'genres'));
    }

    // Search results page
    public function search(Request $request)
    {
        $request->validate(['q' => 'required|string|min:1']);

        $query   = $request->input('q');
        $page    = (int) $request->input('page', 1);
        $results = $this->tmdb->searchMovies($query, $page);
        $genres  = $this->tmdb->getGenres();

        return view('movies.search', compact('results', 'query', 'genres'));
    }

    // Single movie detail page
    public function show(int $id)
    {
        $movie  = $this->tmdb->getMovieDetails($id);
        $genres = $this->tmdb->getGenres();

        $isFavorited   = false;
        $isWatchlisted = false;

        if (auth()->check()) {
            $isFavorited   = auth()->user()->favorites()->where('movie_id', $id)->exists();
            $isWatchlisted = auth()->user()->watchlist()->where('movie_id', $id)->exists();
        }

        return view('movies.show', compact('movie', 'genres', 'isFavorited', 'isWatchlisted'));
    }

    // Movies filtered by genre
    public function byGenre(int $id, Request $request)
    {
        $page         = (int) $request->input('page', 1);
        $movies       = $this->tmdb->getMoviesByGenre($id, $page);
        $genres       = $this->tmdb->getGenres();
        $currentGenre = collect($genres['genres'] ?? [])->firstWhere('id', $id);

        return view('movies.genre', compact('movies', 'genres', 'currentGenre', 'id', 'page'));
    }
}
