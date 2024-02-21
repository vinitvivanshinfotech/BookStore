<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class saveBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_name' => 'required',
            'book_title' => 'required',
            'author_name' => 'required',
            'author_email' => 'required',
            'book_edition' => 'required',
            'description' => 'required',
            'book_cover' => 'required|mimes:jpg,jpeg,png|max:5120', // 5MB Max
            'book_price' => 'required',
            'book_language' => 'required',
            'book_type' => 'required',
        ];
    }
}
