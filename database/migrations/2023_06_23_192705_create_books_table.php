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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('genres_id');
            $table->integer('edition')->unsigned();
            $table->integer('year')->unsigned();
            $table->integer('pages')->unsigned();
            $table->string('format');
            $table->string('license');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('genres_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
