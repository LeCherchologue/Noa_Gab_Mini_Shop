<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'phone',
        'mdp',
    ];

    public function frais()
    {
        return $this->hasMany(\App\Models\Frai::class);
    }
}
