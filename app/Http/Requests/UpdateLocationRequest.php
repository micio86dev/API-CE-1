<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['sometimes', 'string', 'max:255'],
            'phone_number' => ['sometimes', 'string', 'min:8', 'max:15', 'unique:locations,phone_number'],
            'email' => ['sometimes', 'email', 'max:70', 'unique:locations,email'],
            'customer_id' => ['sometimes', 'exists:customers,id'],
            'types' => ['sometimes', 'array'],
            'types.*' => ['integer', 'exists:types,id'],
            'address' => ['sometimes', 'array'],
        ];

        $addressRules = UpdateAddressRequest::prefixedRules('address');

        return array_merge($rules, $addressRules);
    }

    public function messages(): array
    {
        $messages = [
            'name.string' => __('locations/validation.name.string'),
            'name.max' => __('locations/validation.name.max'),
            'phone_number.string' => __('locations/validation.phone_number.string'),
            'phone_number.max' => __('locations/validation.phone_number.max'),
            'phone_number.min' => __('locations/validation.phone_number.min'),
            'phone_number.unique' => __('locations/validation.phone_number.unique'),
            'email.email' => __('locations/validation.email.email'),
            'email.max' => __('locations/validation.email.max'),
            'email.unique' => __('locations/validation.email.unique'),
            'phone_number.unique' => __('locations/validation.phone_number.unique'),
            'customer_id.exists' => __('locations/validation.customer_id.exists'),
            'types.array' => __('locations/validation.types.array'),
            'types.*.integer' => __('locations/validation.types.*.integer'),
        ];

        $addressMessages = UpdateAddressRequest::prefixedMessages('address');

        return array_merge($messages, $addressMessages);
    }
}