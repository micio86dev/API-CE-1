<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
             * User's name.
             * @example User
             */
            'name' => ['required', 'string', 'max:150'],
            /**
             * User's email.
             * @example user@email.com
             */
            'email' => ['required', 'email', 'max:150'],
            /**
             * User's password (min 8 characters).
             * @example password
             */
            'password' => ['required', 'string', 'min:8', 'max:150'],
        ];
    }
}
