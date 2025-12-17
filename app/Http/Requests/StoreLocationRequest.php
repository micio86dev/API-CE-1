<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
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
             * Location's name.
             * @example Mondadori Store Milano
             */
            'name' => ['required', 'string', 'max:255'],
            /**
             * Location's phone number.
             * @example 02/1324567
             */
            'phone_number' => ['nullable', 'string', 'max:50'],
            /**
             * Location's email.
             * @example email@email.com
             */
            'email' => ['nullable', 'email', 'max:255'],
            /**
             * Customer's Location.
             * @example 1
             */
            'customer_id' => ['required', 'exists:customers,id'],
            /**
             * Location's types.
             * @example [1, 2]
             */
            'types' => ['nullable', 'array'],
            'types.*' => ['integer', 'exists:types,id'],
        ] + StoreAddressRequest::prefixedRules('address');
    }



    public function messages(): array
    {
        return [
            // TODO: Add messages
        ];
    }
}
