<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReinscriptionRequest extends FormRequest
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
            'matricule' => 'bail|required|numeric',
            'photo' => 'bail|image|max:2048',
            'adresse' => 'bail|required|max:100',
            'level' => 'bail|required',
            'serie' => 'bail|max:20',
            'academic_year' => 'bail|required',
            'parent_mail' => 'bail|required|email',
            'parent_telephone' => 'bail|numeric'
        ];
    }
}
