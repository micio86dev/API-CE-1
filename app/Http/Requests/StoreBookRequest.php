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
            'title.required' => __('books/validation.title.required'),
            'title.max' => __('books/validation.title.max'),
            'price.decimal' => __('books/validation.price.decimal'),
            'price.max' => __('books/validation.price.max'),
            'collection_id.exists' => __('books/validation.collection_id.exists'),
            'authors.array' => __('books/validation.authors.array'),
            'authors.*.exists' => __('books/validation.authors.*.exists'),
            'types.array' => __('books/validation.types.array'),
            'types.*.exists' => __('books/validation.types.*.exists'),
        ];
    }
}
