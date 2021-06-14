<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nif',
        'endereco',
        'tipo_pagamento',
        'ref_pagamento',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function estampas()
    {
        return $this->hasMany(Estampa::class)->withTrashed();
    }

    public function encomendas()
    {
        return $this->hasMany(Encomenda::class);
    }
}
