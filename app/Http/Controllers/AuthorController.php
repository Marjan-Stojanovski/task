<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use DateTime;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv',
        ]);

        if ($validator->fails()) {
            return redirect()->route('books.create')
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        foreach ($fileContents as $line) {
            $data = str_getcsv($line);
            if (!is_numeric(strtotime($data[2]))) {
                continue;
            } else {
                $birthDate = Carbon::parse($data[2]);
                $useBirthDate = $birthDate->format('Y-m-d');

                $deathDate = Carbon::parse($data[3]);
                $useDeathDate = $deathDate->format('Y-m-d');
                $author = Author::create([
                    'first_name' => $data[0],
                    'last_name' => $data[1],
                    'birth_date' => $useBirthDate,
                    'death_date' => $useDeathDate,
                    'nobel_price' => $data[5],
                ]);

                $books = str_getcsv($data[4]);
                foreach ($books as $book) {
                    Book::create([
                        'author_id' => $author->id,
                        'name' => $book
                    ]);

                }
            }
        }
        return redirect()->route('books.index');
    }
}
