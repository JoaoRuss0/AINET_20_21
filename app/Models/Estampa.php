<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estampa extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cliente_id',
        'categoria_id',
        'nome',
        'descricao',
        'imagem_url',
        'informacao_extra',
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class)->withTrashed();
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class)->withTrashed();
    }

    public function tshirts()
    {
        return $this->hasMany(Tshirt::class);
    }
}
