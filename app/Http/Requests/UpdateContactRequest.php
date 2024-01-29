<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('contacts', 'name')->ignore($this->route('contact')->id)
            ],
            'company_name' => 'required',
            'phone_number' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('contacts', 'email')->ignore($this->route('contact')->id)
            ]
        ];
    }
}
