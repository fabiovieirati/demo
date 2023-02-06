<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro',
        'nome',
        'codigo'
    ];

    public function prices()
    {
        return $this->hasMany(Price::class, 'codigo_id');
    }
}
