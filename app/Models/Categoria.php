<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
    ];

    public function estampas()
    {
        return $this->hasMany(Estampa::class)->withTrashed();
    }

    public function estampas_not_trashed()
    {
        return $this->hasMany(Estampa::class);
    }
}
