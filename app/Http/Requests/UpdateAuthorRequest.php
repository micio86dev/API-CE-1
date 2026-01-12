<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
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
            /**
             * Author's first name.
             * @example Giacomo
             */
            'first_name' => ['required', 'string', 'max:150'],
            /**
             * Author's last name.
             * @example Leopardi
             */
            'last_name' => ['required', 'string', 'max:150'],
            /**
             * Author's books.
             * @example [1, 2, 3]
             */
            'books' => ['sometimes', 'nullable', 'array'],
            'books.*' => ['integer', 'exists:books,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('authors/validation.first_name.required'),
            'first_name.string' => __('authors/validation.first_name.string'),
            'first_name.max' => __('authors/validation.first_name.max'),
            'last_name.required' => __('authors/validation.last_name.required'),
            'last_name.string' => __('authors/validation.last_name.string'),
            'last_name.max' => __('authors/validation.last_name.max'),
            'books.array' => __('authors/validation.books.array'),
            'books.*.exists' => __('authors/validation.books.*.exists'),
        ];
    }
}
