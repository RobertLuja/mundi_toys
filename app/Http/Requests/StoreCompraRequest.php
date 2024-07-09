<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompraRequest extends FormRequest
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
            'glosa' => 'required|min:3|max:100',
            'cantidad' => 'required|regex:/^[1-9][0-9]*$/',
        ];
    }

    public function messages()
    {
        return [
            "cantidad.required" => "El campo cantidad es requerido",
            "cantidad.regex" => "El campo cantidad debe ser de tipo entero",
        ];
    }
}
