<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UpdateUserUniqueData implements Rule
{
    private $usuario;
    private $column;
    public function __construct($usuario, $column)
    {
        $this->usuario = $usuario;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        if( $this->column === 'ci'){
            if(trim(strtolower($this->usuario->ci)) !== trim(strtolower($value))){
                $sql = "select *
                        from usuario
                        where
                        LOWER(TRIM(ci)) = ?
                        ";
                $usuario = DB::select($sql, [$value]);
                if(count($usuario) === 0) return true;
                return false;
            }
            return true;
        }

        if( $this->column === 'nit'){
            if(trim(strtolower($this->usuario->nit)) !== trim(strtolower($value))){
                $sql = "select *
                        from usuario
                        where
                        LOWER(TRIM(nit)) = ?
                        ";
                $usuario = DB::select($sql, [$value]);
                if(count($usuario) === 0) return true;
                return false;
            }
            return true;
        }

        if( $this->column === 'email'){
            if(trim(strtolower($this->usuario->email)) !== trim(strtolower($value))){
                $sql = "select *
                        from usuario
                        where
                        LOWER(TRIM(email)) = ?
                        ";
                $usuario = DB::select($sql, [$value]);
                if(count($usuario) === 0) return true;
                return false;
            }
            return true;
        }
        
    }

    public function message()
    {
        return 'Este campo ya existe en la base de datos.';
    }
}
