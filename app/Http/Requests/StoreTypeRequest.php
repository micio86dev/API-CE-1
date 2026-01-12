<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        $name = $this->request->get('name');
        $alias = $this->request->get('alias');
        if (!$alias || $alias === '') {
            $alias = mb_strtolower($name, 'UTF-8');
        }
        $this->merge([
            'alias' => $alias,
        ]);
    }

    public function rules(): array
    {
        return [
            /**
             * Type's name.
             * @example Shop/Fantasy/etc..
             */
            'name' => ['required', 'string', 'max:60'],
            /**
             * Type's alias.
             * @example shop/fantasy/etc..
             */
            'alias' => ['required', 'string', 'max:60', 'unique:types,alias'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('types/validation.name.required'),
            'name.max' => __('types/validation.name.max'),
            'alias.required' => __('types/validation.alias.required'),
            'alias.max' => __('types/validation.alias.max'),
        ];
    }
}
