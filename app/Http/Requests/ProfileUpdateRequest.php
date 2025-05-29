<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'infix' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'birthdate' => ['required', 'date'],
            'street_name' => ['nullable', 'string', 'max:255'],
            'house_number' => ['nullable', 'string', 'max:10'],
            'addition' => ['nullable', 'string', 'max:10'],
            'postal_code' => [
                'nullable',
                'string',
                'min:6',
                'max:7',
                'regex:/^[1-9][0-9]{3}\s?[a-zA-Z]{2}$/', // Dutch postal code format
            ],
            'place' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'postal_code.regex' => 'The postal code must be in the format 1234 AB.',
        ];
    }
}
