<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegleRemboursement extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'garantie_id',
        'plafond',
        'franchise',
        'taux_remboursement',
    ];
    public function garantie()
    {
        return $this->belongsTo(Garantie::class);
    }
}
