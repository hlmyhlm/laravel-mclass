<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎬 Movie Database
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Search Bar --}}
            <form action="{{ route('movies.search') }}" method="GET" class="mb-6">
                <div class="flex gap-2">
                    <input
                        type="text"
                        name="q"
                        placeholder="Search for a movie..."
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition"
                    >
                        Search
                    </button>
                </div>
            </form>

            {{-- Genre Filter Buttons --}}
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($genres['genres'] as $genre)
                    <a
                        href="{{ route('movies.genre', $genre['id']) }}"
                        class="bg-gray-100 hover:bg-blue-600 hover:text-white text-gray-700 text-sm px-3 py-1 rounded-full transition"
                    >
                        {{ $genre['name'] }}
                    </a>
                @endforeach
            </div>

            {{-- Trending This Week --}}
            <h2 class="text-2xl font-bold mb-4">🔥 Trending This Week</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-10">
                @foreach($trending['results'] as $movie)
                    @include('movies._movie_card', ['movie' => $movie])
                @endforeach
            </div>

            {{-- Popular Movies --}}
            <h2 class="text-2xl font-bold mb-4">⭐ Popular Movies</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($popular['results'] as $movie)
                    @include('movies._movie_card', ['movie' => $movie])
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
