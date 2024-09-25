<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $label
 * @property string $title
 * @property string $page_number
 */
class BookContentResource extends JsonResource
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
            'label' => $this->label,
            'title' => $this->title,
            'page_number' => $this->page_number,
        ];
    }
}
