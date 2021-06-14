<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado',
        'cliente_id',
        'data',
        'preco_total',
        'notas',
        'nif',
        'endereco',
        'tipo_pagamento',
        'ref_pagamento',
        'recibo_url',
    ];

    public function tshirts()
    {
        return $this->hasMany(Tshirt::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
