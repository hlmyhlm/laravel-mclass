<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = config('services.tmdb.key');
        $this->baseUrl = config('services.tmdb.base_url');
    }

    // ─── Private Helper ───────────────────────────────────────────────
    // All API calls go through here. Merges api_key automatically.
    private function get(string $endpoint, array $params = []): array
    {
        $response = Http::get($this->baseUrl . $endpoint, array_merge([
            'api_key'  => $this->apiKey,
            'language' => 'en-US',
        ], $params));

        return $response->json() ?? [];
    }

    // ─── Public Methods ───────────────────────────────────────────────

    public function getPopularMovies(int $page = 1): array
    {
        return $this->get('/movie/popular', ['page' => $page]);
    }

    public function getTrendingMovies(): array
    {
        return $this->get('/trending/movie/week');
    }

    public function searchMovies(string $query, int $page = 1): array
    {
        return $this->get('/search/movie', [
            'query' => $query,
            'page'  => $page,
        ]);
    }

    public function getMovieDetails(int $movieId): array
    {
        // append_to_response lets us fetch credits (cast) in one API call
        return $this->get("/movie/{$movieId}", [
            'append_to_response' => 'credits,videos',
        ]);
    }

    public function getGenres(): array
    {
        return $this->get('/genre/movie/list');
    }

    public function getMoviesByGenre(int $genreId, int $page = 1): array
    {
        return $this->get('/discover/movie', [
            'with_genres' => $genreId,
            'page'        => $page,
            'sort_by'     => 'popularity.desc',
        ]);
    }
}
