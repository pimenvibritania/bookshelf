<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $title
 * @property string $isbn
 * @property int $id
 * @method static create(array $array)
 * @method static find(int $id)
 */
class Book extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn',
        'title',
        'description',
        'published_year',
        'price'
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(BookReview::class);
    }

    /**
     * Get all the bookContents for the Book
     *
     * @return HasMany
     */
    public function bookContents(): HasMany
    {
        return $this->hasMany(BookContent::class);
    }
}
