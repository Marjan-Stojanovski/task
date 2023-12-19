<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'author_id',
        'name',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }
}
