<div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
    <a href="{{ route('movies.show', $movie['id']) }}">
        @if(!empty($movie['poster_path']))
            <img
                src="https://image.tmdb.org/t/p/w342{{ $movie['poster_path'] }}"
                alt="{{ $movie['title'] }}"
                class="w-full h-64 object-cover"
                loading="lazy"
            >
        @else
            <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-400">
                No Image
            </div>
        @endif
    </a>

    <div class="p-3">
        <h3 class="font-semibold text-sm truncate">
            <a href="{{ route('movies.show', $movie['id']) }}" class="hover:text-blue-600">
                {{ $movie['title'] }}
            </a>
        </h3>
        <div class="flex justify-between items-center mt-1 text-xs text-gray-500">
            <span>⭐ {{ number_format($movie['vote_average'] ?? 0, 1) }}</span>
            <span>{{ substr($movie['release_date'] ?? '', 0, 4) }}</span>
        </div>
    </div>
</div>
