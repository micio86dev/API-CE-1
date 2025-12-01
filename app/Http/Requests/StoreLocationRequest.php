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
            'name' => 'required|string|max:255',
            /**
             * Location's phone number.
             * @example 02/1324567
             */
            'phone_number' => 'nullable|string|max:50',
            /**
             * Location's email.
             * @example email@email.com
             */
            'email' => 'nullable|email|max:255',
            /**
             * Customer's Location.
             * @example 1
             */
            'customer_id' => 'required|exists:customers,id',

            'address' => 'nullable|array',
            /**
             * Location's city.
             * @example Milan
             */
            'address.city' => 'required_with:address|string|max:255',
            /**
             * Location's Province.
             * @example MI
             */
            'address.province' => 'required|string|max:100',
            /**
             * Location's country.
             * @example Italy
             */
            'address.country' => 'required_with:address|string|max:100',
            /**
             * Location's street.
             * @example Corso Italia
             */
            'address.street' => 'required_with:address|string|max:255',
            /**
             * Location's street number.
             * @example 10
             */
            'address.street_number' => 'required|string|max:50',
            /**
             * Location's postal code.
             * @example 20131
             */
            'address.zip' => 'required|string|max:20',
            /**
             * Location's latitude.
             * @example 
             */
            'address.lat' => 'nullable|numeric|between:-90,90',
            /**
             * Location's longitude.
             * @example 
             */
            'address.lng' => 'nullable|numeric|between:-180,180',
            /**
             * Location's type.
             * @example [1]
             */
            'types' => 'nullable|array',
            'types.*' => 'exists:types,id',

        ];
    }

    public function messages(): array
    {
        return [
            'address.city.required_with' => 'City is required when providing an address.',
            'address.street.required_with' => 'Street is required when providing an address.',
            'address.country.required_with' => 'Country is required when providing an address.',
            'address.lat.between' => 'Latitude must be between -90 and 90.',
            'address.lng.between' => 'Longitude must be between -180 and 180.',
        ];
    }
}
