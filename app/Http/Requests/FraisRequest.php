<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FraisRequest extends FormRequest
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
            'level' => 'required|string|max:255',
            'frais_inscription' => 'bail|required|numeric',
            'frais_reinscription' => 'bail|required|numeric',
            'frais_scolarite' => 'bail|required|numeric',
            'frais_scolarite_tranche1' => 'bail|required|numeric',
            'frais_scolarite_tranche2' => 'bail|required|numeric',
            'frais_scolarite_tranche3' => 'bail|required|numeric',
            'role' => 'required|string'
        ];
    }
}
