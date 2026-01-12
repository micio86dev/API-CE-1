<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'price' => ['sometimes', 'numeric', 'decimal:0,2', 'min:0', 'max:999.99'],
            /**
             * Book's plot.
             * @example Lorem Ipsum
             */
            'plot' => ['sometimes', 'string'],
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
            'published_at' => ['sometimes', 'nullable', 'date'],
            /**
             * Book's collection.
             * @example 1
             */
            'collection_id' => ['sometimes', 'integer', 'exists:collections,id'],
            /**
             * Book's author/s.
             * @example [1, 2]
             */
            'authors' => ['sometimes', 'array'],
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
            'title.required' => __('books/validation.title.required'),
            'title.string' => __('books/validation.title.string'),
            'title.max' => __('books/validation.title.max'),
            'price.numeric' => __('books/validation.price.numeric'),
            'price.decimal' => __('books/validation.price.decimal'),
            'price.max' => __('books/validation.price.max'),
            'price.min' => __('books/validation.price.min'),
            'collection_id.exists' => __('books/validation.collection_id.exists'),
            'authors.array' => __('books/validation.authors.array'),
            'authors.*.exists' => __('books/validation.authors.*.exists'),
            'types.array' => __('books/validation.types.array'),
            'types.*.exists' => __('books/validation.types.*.exists'),
            'published_at.date' => __('books/validation.published_at.date'),
            'published_at.date_format' => __('books/validation.published_at.date_format'),
        ];
    }
}