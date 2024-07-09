<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    protected $fillable = ["nombre", "descripcion", "icono", "color", "estado",];
    protected $table = "modulo";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function funcionalidades(){
        return $this->hasMany(Funcionalidad::class, "id_modulo");
    }
}
