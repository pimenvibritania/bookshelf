<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use App\Jobs\RetrieveBookContentsJob;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user')->only('store');
        $this->middleware('auth.admin')->only('store');
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        // @TODO implement
        $query = Book::with('authors', 'bookContents', 'reviews');

        if ($request->filled('authors')) {
            $authorId = $request->authors;
            $authorIdsArray = explode(',', $authorId);


            $query->whereHas('authors', function ($query) use ($authorIdsArray) {
                $query->whereIn('id', $authorIdsArray);
            });
        }

        if ($request->filled('sortColumn') && $request->sortColumn == 'published_year') {
            $query->orderBy('published_year', $request->sortDirection ?? 'ASC');
        }

        if ($request->filled('sortColumn') && $request->sortColumn == 'title') {
            $query->orderBy('title', $request->sortDirection ?? 'ASC');
        }

        if ($request->filled('sortColumn') && $request->sortColumn == 'avg_review') {
            $query->withAvg('reviews', 'review')
                ->orderBy('reviews_avg_review', $request->sortDirection ?? 'ASC');
        }


        $books = $query->paginate(15);
        return BookResource::collection($books);
    }

    /**
     * @throws ValidationException
     */
    public function store(PostBookRequest $request): BookResource
    {
        // @TODO implement

        $book = Book::create([
            'isbn' => $request->isbn,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'published_year' => $request->input('published_year'),
            'price' => $request->input('price'),
        ]);

        $book->authors()->attach($request->input('authors'));

        RetrieveBookContentsJob::dispatch($book);

        return new BookResource($book);
    }
}
