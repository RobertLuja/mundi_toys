<?php

namespace App\Http\Requests;

use App\Rules\UpdateUserUniqueData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateUserRequest extends FormRequest
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
        $usuario = DB::table("usuario")->where("id", $this->input("id"))->get()[0];
        return [
            'ci' => [ 'required', 'numeric', 'digits:8', new UpdateUserUniqueData($usuario, "ci") ],
            'nit' => [ 'required', new UpdateUserUniqueData($usuario, "nit") ],
            'nombre' => 'required|min:3|max:80',
            'apellido' => 'required|min:5|max:80',
            'genero' => 'required|in:M,F',
            'direccion' => 'required|min:3',
            'estado' => 'required',
            'rol' => 'required',
            'email' => [ 'required', 'email', new UpdateUserUniqueData($usuario, 'email') ],
        ];
    }
}
