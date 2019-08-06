<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $bookId = $this->route('id');
        return [
            'isbn' => 'max:255|unique:books,isbn,'. $bookId,
            'title' => 'max:255',
            'author' => 'max:100',
            'quantity' => 'integer|min:0',
            'description' => 'max:255',
        ];
    }
}
