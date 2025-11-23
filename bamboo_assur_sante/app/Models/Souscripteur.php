<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Souscripteur extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nom',
        'prenom',
        'tel',
        'nb_enfant',
        'assurance',
        'adresse',
        'beneficiaire',
    ];
    public function beneficiaires()
    {
        return $this->hasMany(Beneficiaire::class);
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
