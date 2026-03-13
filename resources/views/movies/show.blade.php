<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $movie['title'] ?? 'Movie Detail' }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Movie Header --}}
            <div class="flex flex-col md:flex-row gap-8 mb-10">

                {{-- Poster --}}
                <div class="flex-shrink-0">
                    @if(!empty($movie['poster_path']))
                        <img
                            src="https://image.tmdb.org/t/p/w342{{ $movie['poster_path'] }}"
                            alt="{{ $movie['title'] }}"
                            class="rounded-lg shadow-lg w-56"
                        >
                    @else
                        <div class="w-56 h-80 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                            No Image
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-1">{{ $movie['title'] }}</h1>

                    @if(!empty($movie['tagline']))
                        <p class="text-gray-500 italic mb-3">"{{ $movie['tagline'] }}"</p>
                    @endif

                    {{-- Meta --}}
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-4">
                        <span>⭐ {{ number_format($movie['vote_average'] ?? 0, 1) }} / 10</span>
                        <span>🗳 {{ number_format($movie['vote_count'] ?? 0) }} votes</span>
                        <span>📅 {{ $movie['release_date'] ?? 'N/A' }}</span>
                        <span>⏱ {{ $movie['runtime'] ?? '?' }} min</span>
                    </div>

                    {{-- Genres --}}
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($movie['genres'] ?? [] as $genre)
                            <a
                                href="{{ route('movies.genre', $genre['id']) }}"
                                class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full hover:bg-blue-600 hover:text-white transition"
                            >
                                {{ $genre['name'] }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Overview --}}
                    <p class="text-gray-700 leading-relaxed mb-6">
                        {{ $movie['overview'] ?? 'No description available.' }}
                    </p>

                    {{-- Action Buttons --}}
                    @auth
                        <div class="flex flex-wrap gap-3">

                            {{-- Favorite Button --}}
                            @if($isFavorited)
                                <form action="{{ route('favorites.destroy', $movie['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                                        ❤️ Remove from Favorites
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('favorites.store', $movie['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-100 hover:bg-red-500 hover:text-white text-red-600 px-4 py-2 rounded-lg transition">
                                        🤍 Add to Favorites
                                    </button>
                                </form>
                            @endif

                            {{-- Watchlist Button --}}
                            @if($isWatchlisted)
                                <form action="{{ route('watchlist.destroy', $movie['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">
                                        ✅ Remove from Watchlist
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('watchlist.store', $movie['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-yellow-100 hover:bg-yellow-500 hover:text-white text-yellow-700 px-4 py-2 rounded-lg transition">
                                        🕐 Add to Watchlist
                                    </button>
                                </form>
                            @endif

                        </div>
                    @else
                        <p class="text-gray-500 text-sm">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
                            to save this movie to your favorites or watchlist.
                        </p>
                    @endauth

                </div>
            </div>

            {{-- Cast Section --}}
            @if(!empty($movie['credits']['cast']))
                <h2 class="text-2xl font-bold mb-4">🎭 Cast</h2>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-8 gap-4">
                    @foreach(array_slice($movie['credits']['cast'], 0, 8) as $actor)
                        <div class="text-center">
                            @if(!empty($actor['profile_path']))
                                <img
                                    src="https://image.tmdb.org/t/p/w185{{ $actor['profile_path'] }}"
                                    alt="{{ $actor['name'] }}"
                                    class="w-full rounded-lg mb-1 object-cover"
                                    loading="lazy"
                                >
                            @else
                                <div class="w-full h-24 bg-gray-200 rounded-lg flex items-center justify-center text-2xl mb-1">
                                    👤
                                </div>
                            @endif
                            <p class="text-xs font-semibold truncate">{{ $actor['name'] }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $actor['character'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Back Link --}}
            <div class="mt-10">
                <a href="{{ route('movies.index') }}" class="text-blue-600 hover:underline">
                    ← Back to Movies
                </a>
            </div>

        </div>
    </div>
</x-app-layout>


