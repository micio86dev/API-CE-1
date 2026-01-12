<?php

namespace App\Http\Requests;

class StoreAddressRequest extends BaseRequest

{
    public function rules(): array
    {
        return [
            /**
             * Address's city.
             * @example Milano
             */
            'city' => ['required', 'string', 'max:150'],
            /**
             * Address's province.
             * @example Lombardia
             */
            'province' => ['required', 'string', 'max:3'],
            /**
             * Address's country.
             * @example Italia
             */
            'country' => ['required', 'string', 'max:3'],
            /**
             * Address's street.
             * @example Corso Italia
             */
            'street' => ['required', 'string', 'max:100'],
            /**
             * Address's street number.
             * @example 10
             */
            'street_number' => ['required', 'string', 'max:60'],
            /**
             * Address's zip.
             * @example 20131
             */
            'zip' => ['required', 'string', 'max:7'],
            /**
             * Address's latitude.
             * @example 45.4642
             */
            'lat' => ['nullable', 'numeric'],
            /**
             * Address's longitude.
             * @example 9.1914
             */
            'lng' => ['nullable', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'city.required' => __('addresses/validation.city.required'),
            'city.max' => __('addresses/validation.city.max'),
            'province.required' => __('addresses/validation.province.required'),
            'province.max' => __('addresses/validation.province.max'),
            'country.required' => __('addresses/validation.country.required'),
            'country.max' => __('addresses/validation.country.max'),
            'street.required' => __('addresses/validation.street.required'),
            'street.max' => __('addresses/validation.street.max'),
            'street_number.required' => __('addresses/validation.street_number.required'),
            'street_number.max' => __('addresses/validation.street_number.max'),
            'zip.required' => __('addresses/validation.zip.required'),
            'zip.max' => __('addresses/validation.zip.max'),
            'lat.numeric' => __('addresses/validation.lat.numeric'),
            'lng.numeric' => __('addresses/validation.lng.numeric'),
        ];
    }

}
