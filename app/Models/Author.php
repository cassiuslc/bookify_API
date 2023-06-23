<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'biography',
    ];

    protected $casts = [
        'name' => 'string',
        'biography' => 'string',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }

}
