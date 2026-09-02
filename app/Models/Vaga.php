<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    protected $fillable = [
    'user_id',
    'empresa',
    'cargo',
    'link_vaga',
    'anotacoes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
