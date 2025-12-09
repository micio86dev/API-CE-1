<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
             * Address's city.
             * @example Milano
             */
            'city' => ['required', 'string', 'max:150'],
            /**
             * Address's province.
             * @example Lombardia
             */
            'province' => ['required', 'string', 'max:150'],
            /**
             * Address's country.
             * @example Italia
             */
            'country' => ['required', 'string', 'max:150'],
            /**
             * Address's street.
             * @example Corso Italia
             */
            'street' => ['required', 'string', 'max:150'],
            /**
             * Address's street number.
             * @example 10
             */
            'street_number' => ['required', 'string', 'max:150'],
            /**
             * Address's zip.
             * @example 20131
             */
            'zip' => ['required', 'string', 'max:150'],
            /**
             * Address's latitude.
             * @example 45.4642
             */
            'lat' => ['required', 'numeric'],
            /**
             * Address's longitude.
             * @example 9.1914
             */
            'lng' => ['required', 'numeric'],
        ];
    }

    public static function prefixedRules(string $prefix): array
    {
        $baseRules = (new self())->rules();

        $prefixed = [];

        foreach ($baseRules as $field => $rules) {
            $prefixed["{$prefix}.{$field}"] = $rules;
        }

        return $prefixed;
    }
}
