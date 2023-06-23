<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;
use App\Models\Genre;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'genres_id',
        'edition',
        'year',
        'pages',
        'format',
        'license',
        'description',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'license' => 'string',
        'edition' => 'integer',
        'year' => 'integer',
        'pages' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsTo(Genre::class);
    }
}
