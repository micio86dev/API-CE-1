<?php

namespace App\Http\Requests;

class IndexLocationRequest extends IndexBaseRequest
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
             * Location's name.
             * @example Mondadori Store Milano
             */
            'name' => ['nullable', 'string', 'max:150'], 
            /**
             * Location's phone number.
             * @example 02/1324567
             */
            'phone_number' => ['nullable', 'string', 'max:150'],
            /**
             * Location's email.
             * @example email@email.com
             */
            'email' => ['nullable', 'string', 'max:150'],
            /**
             * Location's customer.
             * @example Feltrinelli 
             */
            'customer.name' => ['nullable', 'string', 'max:150'],
            /**
             * Location's mine.
             * @example y/n
             */
            'customer.mine' => ['nullable', 'string', 'in:y,n'],
            /**
             * Location's customer.
             * @example 1
             */
            'customer_id' => ['nullable', 'exists:customers,id'],
            /**
             * Location's address.
             * @example Milan
             */
            'address.city' => ['nullable', 'string', 'max:150'],
            /**
             * Location's address province.
             * @example Lombardia
             */
            'address.province' => ['nullable', 'string', 'max:150'],
            /**
             * Location's address country.
             * @example Italy
             */
            'address.country' => ['nullable', 'string', 'max:150'],
            /**
             * Location's address street.
             * @example Corso Italia
             */
            'address.street' => ['nullable', 'string', 'max:150'],
            /**
             * Location's address street number.
             * @example 10
             */
            'address.street_number' => ['nullable', 'string', 'max:150'],
            /**
             * Location's address zip.
             * @example 20131
             */
            'address.zip' => ['nullable', 'string', 'max:150'],
            /**
             * Location's address latitude.
             * @example 45.4642
             */
            'address.lat' => ['nullable', 'numeric'],
            /**
             * Location's address longitude.
             * @example 9.1914
             */
            'address.lng' => ['nullable', 'numeric'],
            /**
             * Location's types.
             * @example [1, 2]
             */
            'types' => ['nullable', 'array'],
            'types.*' => ['integer', 'exists:types,id'],

        ];
    }
}
