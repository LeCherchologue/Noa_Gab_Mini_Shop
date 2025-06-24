<?php

namespace App\Observers;

use App\Models\Frai;
use App\Observers\BaseObserver;

class FraiObserver extends BaseObserver
{
    public function created(Frai $frai): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté frai ID'.$frai->id,
                'description' => 'Création de frai ID'.$frai->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frai->created_at->format('d/m/Y H:i'),
                'ligne' => $frai->id,
                'table' => 'frais',
                'details' => $frai,
                'api_route' => 'frai.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Frai $frai): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié frai ID'.$frai->id,
                'description' => 'Modification de frai ID'.$frai->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frai->created_at->format('d/m/Y H:i'),
                'ligne' => $frai->id,
                'table' => 'frais',
                'details' => [
                    'before' => $frai->getOriginal(),
                    'after' => $frai,
                ],
                'api_route' => 'frai.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Frai $frai): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé frai ID'.$frai->id,
                'description' => 'Suppression de frai ID'.$frai->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frai->created_at->format('d/m/Y H:i'),
                'ligne' => $frai->id,
                'table' => 'frais',
                'details' => $frai,
                'api_route' => 'frai.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Frai $frai): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré frai ID'.$frai->id,
                'description' => 'Restoration de frai ID'.$frai->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frai->created_at->format('d/m/Y H:i'),
                'ligne' => $frai->id,
                'table' => 'frais',
                'details' => $frai,
                'api_route' => 'frai.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Frai $frai): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement frai ID'.$frai->id,
                'description' => 'Suppression définitive de frai ID'.$frai->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frai->created_at->format('d/m/Y H:i'),
                'ligne' => $frai->id,
                'table' => 'frais',
                'details' => $frai,
                'api_route' => 'frai.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
