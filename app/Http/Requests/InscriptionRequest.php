<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscriptionRequest extends FormRequest
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
            'photo' => 'bail|image|required|max:2048',
            'nom' => 'bail|required|max:50',
            'prenoms' => 'bail|required|max:150',
            'birthday' => 'bail|required|date',
            'adresse' => 'bail|required|max:100',
            'sexe' => 'bail|required|boolean',
            'level' => 'bail|required',
            'serie' => 'bail|max:20',
            'academic_year' => 'bail|required',
            'name_pere' => 'bail|required|max:500',
            'name_mere' => 'bail|required|max:500',
            'parent_mail' => 'bail|required|email',
            'parent_telephone' => 'bail|numeric'
        ];
    }
}
