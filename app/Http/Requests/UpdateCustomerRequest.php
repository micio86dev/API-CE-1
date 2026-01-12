<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
             * Customer's name.
             * @example Feltrinelli S.p.A.
             */
            'name' => ['required', 'string', 'max:150'],
            /**
             * Customer's mine.
             * @example y/n
             */
            'mine' => ['sometimes', 'string', 'in:y,n', 'default:n'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('customers/validation.name.required'),
            'name.max' => __('customers/validation.name.max'),
            'name.string' => __('customers/validation.name.string'),
            'mine.in' => __('customers/validation.mine.in'),
        ];
    }
}
