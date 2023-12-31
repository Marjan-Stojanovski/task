<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthorController extends Controller
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv',
        ]);

        if ($validator->fails()) {
            return redirect()->route('authors.create')
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        $fileRows = file($file->getPathname());

        foreach ($fileRows as $row) {
            $data = str_getcsv($row);
            if (!is_numeric(strtotime($data[2]))) {
                continue;
            } else {
                $birthDate = Carbon::parse($data[2]);
                $useBirthDate = $birthDate->format('Y-m-d');
                if ($data[3] === '') {
                    $useDeathDate = null;
                } else {
                    $deathDate = Carbon::parse($data[3]);
                    $useDeathDate = $deathDate->format('Y-m-d');
                }
                $getAuthor = Author::where('first_name', $data[0])->first();
                $books = str_getcsv($data[4]);

                if (!$getAuthor) {
                    $author = Author::create([
                        'first_name' => $data[0],
                        'last_name' => $data[1],
                        'birth_date' => $useBirthDate,
                        'death_date' => $useDeathDate,
                        'nobel_price' => $data[5],
                    ]);
                    foreach ($books as $book) {
                        Book::create([
                            'author_id' => $author->id,
                            'name' => $book,
                            'slug' => Str::slug($book)
                        ]);
                    }
                } else {
                    foreach ($books as $book) {
                        $getBooks = Book::where('author_id', $getAuthor->id)
                            ->where('slug', Str::slug($book))->first();

                        if (!$getBooks) {
                            Book::create([
                                'author_id' => $getAuthor->id,
                                'name' => $book,
                                'slug' => Str::slug($book)
                            ]);
                        }
                    }
                }
            }
        }
        return redirect()->route('authors.index');
    }
}
