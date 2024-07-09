<?php

namespace App\Http\Requests;

use App\Rules\UserUniqueData;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'ci' => [ 'required', 'min:8', 'max:10', new UserUniqueData('usuarios', 'ci') ],
            'nombre' => 'required|min:3|max:80',
            'apellido' => 'required|min:5|max:80',
            'genero' => 'required|in:M,F',
            'direccion' => 'required|min:3',
            'nit' => 'required',
            'rol' => 'required',
            'estado' => 'required',
            'fecha_nacimiento' => 'required',
            'email' => [ 'required', 'email', new UserUniqueData('usuarios', 'email') ],
            'password' => 'required|min:4',
        ];
    }
}
