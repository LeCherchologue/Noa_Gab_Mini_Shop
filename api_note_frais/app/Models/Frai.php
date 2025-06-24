<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frai extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'dates',
        'montant',
        'lieu',
        'divers',
        'user_id',
    ];

    public function personne()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
