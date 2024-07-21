<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
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
            'name' => 'bail|required|max:100',
            'logo' => 'bail|image|required|max:2048',
            'email' => 'bail|required|email',
            'adresse' => 'bail|required|max:60',
            'phone_number' => 'bail|required|numeric',
            'password' => 'bail|required|min:8'
        ];
    }
}