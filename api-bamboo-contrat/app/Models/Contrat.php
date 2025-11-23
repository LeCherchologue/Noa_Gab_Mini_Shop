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
}
