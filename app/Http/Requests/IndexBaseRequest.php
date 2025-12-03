<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexBaseRequest extends FormRequest
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
             * Generic search key, find in author's firstName and lastName.
             * @example Giacomo
             */
            'search' => ['nullable', 'string', 'max:255'],

            /**
             * Number of page
             * @example [1, 2, 3]
             */
            'page' => ['nullable', 'integer', 'min:1'],

            /**
             * Number of records in any page (max 100)
             * @example [1, 2, 3]
             */
            'perpage' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
