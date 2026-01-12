<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:150'],
            /**
             * User's email.
             * @example user@email.com
             */
            'email' => ['sometimes', 'email', 'max:150'],
            /**
             * User's password (min 8 characters).
             * @example password
             */
            'password' => ['sometimes', 'string', 'min:8', 'max:150'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => __('users/validation.name.string'),
            'name.max' => __('users/validation.name.max'),
            'email.email' => __('users/validation.email.email'),
            'email.max' => __('users/validation.email.max'),
            'password.string' => __('users/validation.password.string'),
            'password.min' => __('users/validation.password.min'),
            'password.max' => __('users/validation.password.max'),
        ];
    }
}
