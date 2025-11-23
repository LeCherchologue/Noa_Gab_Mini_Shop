<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echeance extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'montant',
        'date_echeance',
        'date_reglement',
        'statut',
        'id_paiement',
    ];
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }
}
