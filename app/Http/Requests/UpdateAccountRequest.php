<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (! user()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'country' => ['required', 'integer', 'exists:countries,id'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(user()->id)],
            'date_format' => ['nullable', 'string'],
            'timezone' => ['nullable', 'string'],
        ];
    }
}
