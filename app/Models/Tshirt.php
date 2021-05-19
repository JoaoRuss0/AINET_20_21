<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tshirt extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'encomenda_id',
        'estampa_id',
        'cor_codigo',
        'tamanho',
        'quantidade',
        'preco_un',
        'subtotal',
    ];

    public function encomenda()
    {
        return $this->belongsTo(Encomenda::class);
    }

    public function estampa()
    {
        return $this->belongsTo(Estampa::class);
    }

    public function cor()
    {
        return $this->belongsTo(Cor::class, 'cor_codigo', 'codigo');
    }
}
