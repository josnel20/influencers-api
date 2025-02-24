<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Influenciador extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome', 
        'usuario_instagram', 
        'quantidade_seguidores', 
        'categoria'];

    public function campanhas()
    {
        return $this->belongsToMany(Campanha::class, 'campanha_influenciador');
    }
}
