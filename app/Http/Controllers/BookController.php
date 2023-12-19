<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        $books = Book::all();

        $data = [
            'authors' => $authors,
            'books' => $books
        ];
        return view('index')->with($data);
    }

    public function create()
    {
        return view('create');
    }
}
