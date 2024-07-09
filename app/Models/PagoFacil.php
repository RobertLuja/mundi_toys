<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoFacil extends Model
{
    use HasFactory;
    protected $table = "pagofacil";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];

    public function venta(){
        return $this->belongsTo(Venta::class, "id_venta");
    }
}
