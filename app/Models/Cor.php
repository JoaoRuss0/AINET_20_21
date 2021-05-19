<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cor extends Model
{
    use HasFactory, SoftDeletes;

    public $primaryKey = 'codigo';
    public $incrementing = false;
    protected $table = 'cores';
    protected $keyType = 'string';
    protected $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
    ];

    public function tshirts()
    {
        return $this->hasMany(Tshirt::class, 'cor_codigo', 'codigo');
    }
}
