<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
             * Title for a book.
             * @example The Lord of the Rings
             */
            'title' => ['required', 'string', 'max:150'],
            /**
             * Book's price.
             * @example 9.99
             */
            'price' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:999.99'],
            /**
             * Book's plot.
             * @example Lorem Ipsum
             */
            'plot' => ['required', 'string'],
            /**
             * Literary genres.
             * @example [1]
             */
            'types' => ['nullable', 'array'],
            'types.*' => ['integer', 'exists:types,id'],
            /**
             * Publication date.
             * @example 
             */
            'published_at' => ['nullable', 'date', 'date_format:Y-m-d'],
            /**
             * Book's collection.
             * @example 1
             */
            'collection_id' => ['required', 'integer', 'exists:collections,id'],
            /**
             * Book's author/s.
             * @example [1, 2]
             */
            'authors' => ['nullable', 'array'],
            'authors.*' => ['integer', 'exists:authors,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'book title',
            'price' => 'book price',
            'plot' => 'plot description',
            'published_at' => 'publication date',
            'collection_id' => 'collection',
            'authors' => 'authors',
            'authors.*' => 'author',
            'types' => 'literary genres',
            'types.*' => 'literary genre',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The book title is required.',
            'title.max' => 'The book title cannot exceed 150 characters.',
            'price.decimal' => 'The price must have at most 2 decimal places.',
            'price.max' => 'The price cannot exceed 999.99.',
            'collection_id.exists' => 'The selected collection does not exist.',
            'authors.array' => 'Authors must be provided as an array.',
            'authors.*.exists' => 'One or more selected authors do not exist.',
            'types.array' => 'Types must be provided as an array.',
            'types.*.exists' => 'One or more selected literary genres do not exist.',
        ];
    }
}
