<?php

namespace App\Http\Requests;

class IndexCustomerRequest extends IndexBaseRequest
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
                    * Customer's name.
             * @example John Doe
             */
            'name' => ['nullable', 'string', 'max:150'],
            /**
             * Customer's mine.
             * @example Y/N
             */
            'mine' => ['nullable', 'string', 'in:y,n'],
            /**
             * Customer's locations address.
             * @example Milan
             */
            'locations.address.city' => ['nullable', 'string', 'max:100'],
            /**
             * Customer's locations address province.
             * @example Lombardia
             */
            'locations.address.province' => ['nullable', 'string', 'max:100'],
            /**
             * Customer's locations address country.
             * @example Italy
             */
            'locations.address.country' => ['nullable', 'string', 'max:100'],
            /**
             * Customer's locations address street.
             * @example Corso Italia
             */
            'locations.address.street' => ['nullable', 'string', 'max:255'],
            /**
             * Customer's locations address street number.
             * @example 10
             */
            'locations.address.street_number' => ['nullable', 'string', 'max:50'],
            /**
             * Customer's locations address zip.
             * @example 20131
             */
            'locations.address.zip' => ['nullable', 'string', 'max:20'],
        ];
    }
}
