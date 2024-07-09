<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserUniqueData implements Rule
{
    protected $table;
    protected $column;

    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function passes($attribute, $value)
    {
        $sql = "select *
                from usuario
                where
                LOWER(TRIM(ci)) = ? or
                LOWER(TRIM(email)) = ?;
                ";
        $usuarios = DB::select($sql, [$value, $value]);
        
        if(count($usuarios) === 0) return true;
        return false;
        
    }

    public function message()
    {
        return 'Este campo ya existe en la base de datos.';
    }
}
