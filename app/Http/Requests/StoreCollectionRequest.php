<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionRequest extends FormRequest
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
             * Collection's name.
             * @example Collana Narrativa
             */
            'name' => ['required', 'string', 'max:150'],
            /**
             * Collection's description.
             * @example Collana di narrativa italiana
             */
            'description' => ['nullable', 'string', 'max:255'],
            /**
             * Collection's published at.
             * @example 2025-01-01
             */
            'published_at' => ['nullable', 'date', 'date_format:Y-m-d'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('collections/validation.name.required'),
            'name.max' => __('collections/validation.name.max'),
            'description.max' => __('collections/validation.description.max'),
            'published_at.date' => __('collections/validation.published_at.date'),
            'published_at.date_format' => __('collections/validation.published_at.date_format'),
        ];
    }
}
