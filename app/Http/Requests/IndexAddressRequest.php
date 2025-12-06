<?php

namespace App\Http\Requests;

class IndexAddressRequest extends IndexBaseRequest
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
        return parent::rules() + [
            /**
             * Address's city.
             * @example Milano
             */
            'city' => ['nullable', 'string', 'max:150'],
            /**
             * Address's province.
             * @example Lombardia
             */
            'province' => ['nullable', 'string', 'max:150'],
            /**
             * Address's country.
             * @example Italia
             */
            'country' => ['nullable', 'string', 'max:150'],
            /**
             * Address's street.
             */
            'street' => ['nullable', 'string', 'max:150'],
            /**
             * Address's street number.
             * @example 10
             */
            'street_number' => ['nullable', 'string', 'max:150'],
            /**
             * Address's zip.
             * @example 20131
             */
            'zip' => ['nullable', 'string', 'max:150'],
            /**
             * Address's latitude.
             * @example 45.4642
             */
            'lat' => ['nullable', 'float'],
            /**
             * Address's longitude.
             * @example 9.1914
             */
            'lng' => ['nullable', 'float'],
        ];
    }
}
