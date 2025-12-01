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
            'first_name' => ['sometimes', 'string', 'max:150'],
            /**
             * Author's last name.
             * @example Leopardi
             */
            'last_name' => ['sometimes', 'string', 'max:150'],
            /**
             * Author's books.
             * @example [1, 2, 3]
             */
            'books' => ['sometimes', 'nullable', 'array'],
            'books.*' => ['integer', 'exists:books,id'],
        ];
    }
}
