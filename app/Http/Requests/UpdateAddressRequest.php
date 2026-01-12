<?php

namespace App\Http\Requests;


class UpdateAddressRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            /**
             * Address's city.
             * @example Milano
             */
            'city' => ['sometimes', 'string', 'max:150'],
            /**
             * Address's province.
             * @example MI
             */
            'province' => ['sometimes', 'string', 'min:2', 'max:3'],
            /**
             * Address's country.
             * @example Italia
             */
            'country' => ['sometimes', 'string', 'max:150'],
            /**
             * Address's street.
             * @example Corso Italia
             */
            'street' => ['sometimes', 'string', 'max:150'],
            /**
             * Address's street number.
             * @example 10
             */
            'street_number' => ['sometimes', 'string', 'max:150'],
            /**
             * Address's zip.
             * @example 20131
             */
            'zip' => ['sometimes', 'string', 'max:150'],
            /**
             * Address's latitude.
             * @example 45.4642
             */
            'lat' => ['sometimes', 'numeric'],
            /**
             * Address's longitude.
             * @example 9.1914
             */
            'lng' => ['sometimes', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'city.string' => __('addresses/validation.city.string'),
            'city.max' => __('addresses/validation.city.max'),
            'province.string' => __('addresses/validation.province.string'),
            'province.min' => __('addresses/validation.province.min'),
            'province.max' => __('addresses/validation.province.max'),
            'country.string' => __('addresses/validation.country.string'),
            'country.max' => __('addresses/validation.country.max'),
            'street.string' => __('addresses/validation.street.string'),
            'street.max' => __('addresses/validation.street.max'),
            'street_number.string' => __('addresses/validation.street_number.string'),
            'street_number.max' => __('addresses/validation.street_number.max'),
            'zip.string' => __('addresses/validation.zip.string'),
            'zip.max' => __('addresses/validation.zip.max'),
            'lat.numeric' => __('addresses/validation.lat.numeric'),
            'lng.numeric' => __('addresses/validation.lng.numeric'),
        ];
    }
}
