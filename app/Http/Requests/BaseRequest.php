<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array{
        return [];
    }

    public static function prefixedRules(string $prefix): array
    {
        $baseRules = (new static())->rules();

        $prefixed = [];

        foreach ($baseRules as $field => $rules) {
            $prefixed["{$prefix}.{$field}"] = $rules;
        }

        return $prefixed;
    }

    public static function prefixedMessages(string $prefix): array
    {
        $baseMessages = (new static())->messages();

        $prefixed = [];

        foreach ($baseMessages as $field => $message) {
            $prefixed["{$prefix}.{$field}"] = $message;
        }

        return $prefixed;
    }
}
