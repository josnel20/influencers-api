<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Campanha extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'orcamento',
        'descricao',
        'data_inicio',
        'data_fim',
    ];

    public function influenciadores()
    {
        return $this->belongsToMany(Influenciador::class, 'campanha_influenciador');
    }

}