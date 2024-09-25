<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookReviewResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BooksReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user')->only('store');
    }

    public function store(int $bookId, PostBookReviewRequest $request): JsonResponse | BookReviewResource
    {
        // @TODO implement
        $book = Book::find($bookId);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $review = BookReview::create([
            'book_id' => $book->id,
            'user_id' => $request->user()->id,
            'review' => $request->review,
            'comment' => $request->comment,
        ]);

        return new BookReviewResource($review);
    }

    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        // @TODO implement
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        $review = BookReview::where('book_id', $bookId)->find($reviewId);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], Response::HTTP_NOT_FOUND);
        }

        $review->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
