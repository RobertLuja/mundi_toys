<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'venta';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];

    public function cliente(){
        return $this->belongsTo(User::class, "id_cliente");
    }

    public function usuario(){
        return $this->belongsTo(User::class, "id_usuario");
    }

    public function detalleVentas() {
        return $this->hasMany(DetalleVenta::class, "id_venta");
    }

    public function pagosFacil() {
        return $this->hasMany(PagoFacil::class, "id_venta");
    }

    public static function customDetalleVentas($id) {
        $venta = static::find($id); //Similar a: $venta = Venta::find($id);
        $venta->cliente;

        if(count($venta->pagosFacil) == 0){
            $venta->pagoFacil = null;
        }else{
            foreach($venta->pagosFacil as $pagoFacil){
                if($pagoFacil->estado == 1){
                    $venta->pagoFacil = $pagoFacil;
                    break;
                }
            }
        }
        $venta->cantidadTransaccion = count($venta->pagosFacil);
        $venta->makeHidden(["pagosFacil"]);
        
        $precioTotal = 0;
        
        foreach($venta->detalleVentas as $detalleVenta){
            $producto = $detalleVenta->movimiento->producto;
            
            $precioTotalProducto = $detalleVenta->cantidad * $producto->precio;

            $precioTotal += $precioTotalProducto;

            $detalleVenta->precioTotal = $precioTotalProducto;
            $detalleVenta->producto = $producto;
            $detalleVenta->makeHidden(["movimiento"]);
        }
        $venta->precioTotal = $precioTotal;
        return $venta;
    }
}
