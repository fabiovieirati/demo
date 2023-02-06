<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_id',
        'minimo_vidas',
        'faixa1',
        'faixa2',
        'faixa3',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'codigo');
    }
}
