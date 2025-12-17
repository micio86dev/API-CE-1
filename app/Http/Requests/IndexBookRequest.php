<?php

namespace App\Http\Requests;

class IndexBookRequest extends IndexBaseRequest
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
        return parent::rules() + [
            /**
             * Book's title.
             * @example The Lord of the Rings
             */
            'title' => ['nullable', 'string', 'max:150'],
            /**
             * Book's price.
             * @example 9.99
             */
            'price' => ['nullable', 'numeric', 'decimal:0,2', 'min:0', 'max:999.99'],
            /**
             * Book's price max.
             * @example 9.99
             */
            'max_price' => ['nullable', 'numeric', 'decimal:0,2', 'min:0', 'max:999.99'],
            /**
             * Book's price less than.
             * @example 9.99
             */
            'min_price' => ['nullable', 'numeric', 'decimal:0,2', 'min:0', 'max:999.99'],
            /**
             * Book's publication date.
             * @example 2025-01-01
             */
            'published_at' => ['nullable', 'date', 'date_format:Y-m-d'],
            /**
             * Book's publication date max.
             * @example 2025-01-01
             */
            'published_before' => ['nullable', 'date', 'date_format:Y-m-d'],
            /**
             * Book's publication date after.
             * @example 2025-01-01
             */
            'published_after' => ['nullable', 'date', 'date_format:Y-m-d'],
            /**
             * Book's collection name.
             * @example Collana Narrativa
             */
            'collection.name' => ['nullable', 'string', 'max:60'],
            /**
             * Book's author first name.
             * @example Giacomo
             */
            'authors.first_name' => ['nullable', 'string', 'max:60'],
            /**
             * Book's author last name.
             * @example Leopardi
             */
            'authors.last_name' => ['nullable', 'string', 'max:60'],
            /**
             * Book's type name.
             * @example Fantasy
             */
            'types.name' => ['nullable', 'string', 'max:60'],
        ];
    }
}
