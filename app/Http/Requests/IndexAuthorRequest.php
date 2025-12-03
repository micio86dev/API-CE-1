<?php

namespace App\Http\Requests;

class IndexAuthorRequest extends IndexBaseRequest
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
             * Author's first name.
             * @example Giacomo
             */
            'first_name' => ['nullable', 'string', 'max:150'],
            /**
             * Author's last name.
             * @example Leopardi
             */
            'last_name' => ['nullable', 'string', 'max:150'],
        ];
    }
}
