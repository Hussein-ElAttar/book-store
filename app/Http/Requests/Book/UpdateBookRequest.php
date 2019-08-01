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
        $bookId = $this->route('book');
        return [
            'isbn' => 'required|max:255|unique:books,isbn,'. $bookId,
            'title' => 'required|max:255',
            'author' => 'required|max:100',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|max:255',
        ];
    }
}
