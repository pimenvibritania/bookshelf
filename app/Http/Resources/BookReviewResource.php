<?php

namespace App\Http\Resources;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Book $book
 * @property int $review
 * @property string $comment
 * @property int $id
 * @property User $user
 * @property int $user_id
 */
class BookReviewResource extends JsonResource
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
            'review' => $this->review,
            'comment' => $this->comment,
            'user' => [
                'id' => $this->user_id,
                'name' => $this->user->name
            ],
        ];
    }
}
