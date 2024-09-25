<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        // @TODO implement
        return [
            'isbn' => [
                'required',
                'string',
                'size:13',
                'unique:books,isbn',
                'regex:/^978[0-9]{10}$/'
            ],
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'authors' => 'required|array|min:1',
            'authors.*' => [
                'required',
                'integer',
                'exists:authors,id',
                'array' => false
            ],
            'published_year' => 'required|integer|between:1900,2020',
            'price' => 'required|numeric|min:0',
        ];
    }
}
