<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method map(\Closure $param)
 * @property int $id
 * @property string $title
 * @property string $label
 * @property int $page_number
 */
class BookContent extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id',
        'label',
        'title',
        'page_number'
    ];

    /**
     * Get the book that owns the BookContent
     *
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
