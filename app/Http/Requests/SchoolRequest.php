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
            'name' => 'bail|alpha_dash|required|max:100',
            'logo' => 'bail|required|image',
            'email' => 'bail|required|email',
            'adresse' => 'bail|required|max:60',
            'phone_number' => 'bail|required|regex:/^(\+?\d{1,3})?[-. (]*(\d{1,4})[-. )]*(\d{1,4})[-. ]*(\d{1,9})$/',
            'password' => 'bail|required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#_-])[A-Za-z\d@$!%*?&#_-]{8,}$/'
        ];
    }
}
