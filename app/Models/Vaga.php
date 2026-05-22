<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    protected $fillable = [
    'empresa',
    'cargo',
    'link_vaga',
    'anotacoes'
    ];
}
