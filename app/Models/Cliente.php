<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

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
}
