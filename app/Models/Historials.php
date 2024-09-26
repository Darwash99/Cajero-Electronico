<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historials extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'estado_id',
        'fecha',
        'cantidad',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
