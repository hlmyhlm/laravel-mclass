<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('watchlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('movie_id'); //TMDB movie ID
            $table->string('title');
            $table->string('poster_path')->nullable();
            $table->decimal('vote_average', 4, 2)->nullable();
            $table->date('release_year')->nullable();
            $table->boolean('watched')->default(false); // Whether the user has watched the movie or not
            $table->timestamps();

            //One user can only add a movie to watchlist once
            $table->unique(['user_id', 'movie_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watchlists');
    }
};
