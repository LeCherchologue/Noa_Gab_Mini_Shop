<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'reference',
        'montant_total',
        'type_paiement',
        'statut',
        'moyen_paiement',
        'date_paiement',
        'id_contrat',
        'client_bamboo_emf',
    ];
    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }
}
