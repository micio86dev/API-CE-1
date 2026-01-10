<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
             * Customer's name.
             * @example Feltrinelli S.p.A.
             */
            'name' => ['required', 'string', 'max:150'],
            /**
             * Mine office/warehouse or customer?
             * @example y/n
             */
            'mine' => ['required', 'string', 'in:y,n', 'default:n'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('customers/validation.name.required'),
            'name.max' => __('customers/validation.name.max'),
            'mine.required' => __('customers/validation.mine.required'),
            'mine.in' => __('customers/validation.mine.in'),
        ];
    }
}
