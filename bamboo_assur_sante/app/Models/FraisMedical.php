<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraisMedical extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'demande_remboursement_id',
        'type_frais',
        'montant',
        'description',
        'justificatif',
    ];

    public function demandeRemboursement()
    {
        return $this->belongsTo(DemandeRemboursement::class);
    }
}
