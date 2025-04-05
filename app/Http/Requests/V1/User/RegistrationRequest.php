<?php

namespace App\Http\Requests\V1\User;

use App\Rules\SaudiIDRule;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'language' => ['nullable', 'string', 'in:en,ar'],

            'transfer' => ['required', 'boolean'],
            'national_id' => ['required', new SaudiIDRule],
            'owner_national_id' => [
                'required_if:transfer,true',
                'different:national_id',
                new SaudiIDRule,
            ],

            'reg_type' => [
                'required',
                'string',
                'in:sequence_number,custom_card',
                function ($attribute, $value, $fail) {
                    if (request('transfer') && $value !== 'sequence_number') {
                        $fail('The registration type must be sequence number when transferring ownership.');
                    }
                }
            ],
            'sequence_number' => ['required_if:reg_type,sequence_number', 'string', 'size:10'],
            'custom_card' => ['required_if:reg_type,custom_card', 'string', 'size:10'],
            'manufacturing_year' => ['required_if:reg_type,custom_card', 'string', 'size:4'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'owner_national_id.different' => "you can't transfer ownership to your self.",
        ];
    }
} 