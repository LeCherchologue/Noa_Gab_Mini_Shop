<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'date_debut',
        'date_fin',
        'mode_paiement',
        'tiers_payant',
        'id_souscripteur',
    ];
    public function souscripteur()
    {
        return $this->belongsTo(Souscripteur::class);
    }

    public function garanties()
    {
        return $this->belongsToMany(Garantie::class, 'contrat_garanties');
    }
}
