<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preco extends Model
{
    use HasFactory;

    protected $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'preco_un_catalogo',
        'preco_un_proprio',
        'preco_un_catalogo_proprio',
        'preco_un_proprio_proprio',
        'quantidade_desconto',
    ];
}
