<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /**
             * Image file to upload.
             */
            // Either upload a new file...
            'image' => ['required_without:image_id', 'prohibited_with:image_id', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5MB

            // ...or attach an existing uploaded image.
            'image_id' => ['required_without:image', 'prohibited_with:image', 'integer', 'exists:images,id'],

            /**
             * Optional image categories (reuses your types/has_types).
             * Example: [1, 2]
             */
            'types' => ['nullable', 'array'],
            'types.*' => ['integer', 'exists:types,id'],

            /**
             * Mark as primary image for the parent model.
             */
            'is_primary' => ['sometimes', 'boolean'],

            /**
             * Sorting inside the parent gallery.
             */
            'sort_order' => ['sometimes', 'integer', 'min:0'],

            /**
             * Optional extra metadata you allow clients to set.
             */
            'meta' => ['sometimes', 'array'],
            'meta.alt' => ['sometimes', 'string', 'max:255'],
            'meta.caption' => ['sometimes', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => __('images/validation.image.required'),
            'image.image' => __('images/validation.image.image'),
            'image.mimes' => __('images/validation.image.mimes'),
            'image.max' => __('images/validation.image.max'),

            'types.array' => __('images/validation.types.array'),
            'types.*.exists' => __('images/validation.types.*.exists'),

            'is_primary.boolean' => __('images/validation.is_primary.boolean'),
            'sort_order.integer' => __('images/validation.sort_order.integer'),
            'sort_order.min' => __('images/validation.sort_order.min'),

            'meta.array' => __('images/validation.meta.array'),
            'meta.alt.string' => __('images/validation.meta.alt.string'),
            'meta.alt.max' => __('images/validation.meta.alt.max'),
            'meta.caption.string' => __('images/validation.meta.caption.string'),
            'meta.caption.max' => __('images/validation.meta.caption.max'),
        ];
    }
}