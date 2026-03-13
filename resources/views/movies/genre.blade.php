<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎬 {{ $currentGenre['name'] ?? 'Genre' }} Movies
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Genre Filter Buttons --}}
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($genres['genres'] as $genre)
                    <a
                        href="{{ route('movies.genre', $genre['id']) }}"
                        class="text-sm px-3 py-1 rounded-full transition
                            {{ $genre['id'] == $id
                                ? 'bg-blue-600 text-white'
                                : 'bg-gray-100 hover:bg-blue-600 hover:text-white text-gray-700' }}"
                    >
                        {{ $genre['name'] }}
                    </a>
                @endforeach
            </div>

            {{-- Heading + Count --}}
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold">{{ $currentGenre['name'] ?? 'Movies' }}</h2>
                <span class="text-sm text-gray-500">
                    {{ number_format($movies['total_results'] ?? 0) }} movies found
                </span>
            </div>

            {{-- Movie Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8">
                @foreach($movies['results'] as $movie)
                    @include('movies._movie_card', ['movie' => $movie])
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center items-center gap-4 mt-6">
                @if($page > 1)
                    <a
                        href="{{ route('movies.genre', [$id, 'page' => $page - 1]) }}"
                        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg transition"
                    >
                        ← Prev
                    </a>
                @endif

                <span class="text-gray-600 text-sm">
                    Page {{ $page }} of {{ $movies['total_pages'] }}
                </span>

                @if($page < $movies['total_pages'])
                    <a
                        href="{{ route('movies.genre', [$id, 'page' => $page + 1]) }}"
                        class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg transition"
                    >
                        Next →
                    </a>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
