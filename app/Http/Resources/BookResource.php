<?php

namespace App\Http\Resources;

use App\Author;
use App\BookContent;
use App\BookReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $isbn
 * @property string $title
 * @property string $description
 * @property int $published_year
 * @property Author $authors
 * @property BookContent $bookContents
 * @property int $price
 * @property BookReview $reviews
 */
class BookResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'title' => $this->title,
            'description' => $this->description,
            'published_year' => $this->published_year,
            'price' => $this->price,
            'price_rupiah' => usd_to_rupiah_format($this->price),
            'authors' => $this->authors->map(function (Author $author) {
                return ['id' => $author->id, 'name' => $author->name, 'surname' => $author->surname];
            })->toArray(),
            'book_contents' => $this->bookContents->map(function (BookContent $bookContent) {
                return ['id' => $bookContent->id, 'title' => $bookContent->title, 'label' => $bookContent->label,
                    'page_number' => $bookContent->page_number];
            })->toArray(),
            'review' => [
                'avg' => (int) round($this->reviews->avg('review')),
                'count' => (int) $this->reviews->count(),
            ],
        ];
    }
}
