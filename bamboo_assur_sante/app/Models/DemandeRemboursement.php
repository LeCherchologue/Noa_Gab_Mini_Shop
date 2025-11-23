<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeRemboursement extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'contrat_id',
        'beneficiare_id',
        'reference',
        'date_reclamation',
        'statut',
        'total',
        'montant_rembourse',
        'motif_refus',
    ];
    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    public function beneficiaire()
    {
        return $this->belongsTo(Beneficiaire::class);
    }

    public function fraisMedicaux()
    {
        return $this->hasMany(FraisMedical::class);
    }
}
