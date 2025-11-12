<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'user_id', // <-- AÑADE ESTA LÍNEA
        'cantidad',
        'total',
        'fecha',
        'tipo_pago',
    ];

    public $timestamps = false;

    /**
     * Define la relación: Una venta pertenece a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'fecha' => 'datetime', // <-- AÑADE ESTO
    ];

    /**
     * Define la relación: Una venta pertenece a un usuario (vendedor).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
