<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BrightBox Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Collapsible wrapper -->
        <div
            class="collapse navbar-collapse justify-content-center"
            id="navbarCenteredExample"
        >
            <!-- Left links -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('authors.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('authors.create') }}">Add List Items</a>
                </li>
                <!-- Navbar dropdown -->
            </ul>
            <!-- Left links -->
        </div>
        <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
</nav>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <h1>List of Author's</h1>
        </div>
    </div>
</div>
@if(!(count($authors) === 0))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Date of Death</th>
                        <th>Books</th>
                        <th>Nobel Prize Winner</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($authors as $author)
                            <?php
                            $birthDate = Illuminate\Support\Carbon::parse($author->birth_date);
                            $useBirthDate = $birthDate->format('m/d/Y');
                            $deathDate = Illuminate\Support\Carbon::parse($author->death_date);
                            $useDeathDate = $deathDate->format('m/d/Y');
                            ?>
                        <tr>
                            <td>{{ $author->first_name }}</td>
                            <td>{{ $author->last_name }}</td>
                            <td>{{ $useBirthDate }}</td>
                            @if(empty($author->death_date))
                                <td>/</td>
                            @endif
                            @if(!empty($author->death_date))
                            <td>{{ $useDeathDate }}</td>
                            @endif
                            <td>
                                @foreach($books->where('author_id', $author->id) as $book)
                                    {{$book->name}},
                                @endforeach
                            </td>
                            <td>{{ $author->nobel_price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
<br>
@if(count($authors) === 0)
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <h3>No data available</h3>
                </div>
            </div>
        </div>
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
