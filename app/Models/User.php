<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'usuario';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function comprasUsuario() {
        return $this->hasMany(Compra::class, "id_usuario");
    }

    public function comprasProveedor() {
        return $this->hasMany(Compra::class, "id_proveedor");
    }

    public function traspasos() {
        return $this->hasMany(Traspaso::class, "id_empleado");
    }

    public function ventasUsuario() {
        return $this->hasMany(Venta::class, "id_usuario");
    }

    public function ventasCliente() {
        return $this->hasMany(Venta::class, "id_cliente");
    }

    public function roles() {
        return $this->belongsToMany(Role::class, "role_usuario", "id_usuario", "id_role");
    }
}
