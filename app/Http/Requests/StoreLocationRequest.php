<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            /**
             * Location's name.
             * @example Mondadori Store Milano
             */
            'name' => ['required', 'string', 'max:255'],
            /**
             * Location's phone number.
             * @example 02/1324567
             */
            'phone_number' => ['required', 'string', 'min:8', 'max:15', 'unique:locations,phone_number'],
            /**
             * Location's email.
             * @example email@email.com
             */
            'email' => ['nullable', 'email', 'max:70', 'unique:locations,email'],
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

            'address' => ['required', 'array'],
        ];
      

        $addressRules = StoreAddressRequest::prefixedRules('address');

        return array_merge($rules, $addressRules);
    }

    

    public function messages(): array
    {
        $messages = [
            'name.required' => __('locations/validation.name.required'),
            'name.max' => __('locations/validation.name.max'),
            'phone_number.max' => __('locations/validation.phone_number.max'),
            'email.email' => __('locations/validation.email.email'),
            'email.max' => __('locations/validation.email.max'),
            'customer_id.required' => __('locations/validation.customer_id.required'),
            'customer_id.exists' => __('locations/validation.customer_id.exists'),
            'types.array' => __('locations/validation.types.array'),
            'types.*.integer' => __('locations/validation.types.*.integer'),
        ];

        $addressMessages = StoreAddressRequest::prefixedMessages('address');

        return array_merge($messages, $addressMessages);
    }
}
