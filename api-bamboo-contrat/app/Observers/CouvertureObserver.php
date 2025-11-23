<?php

namespace App\Observers;

use App\Models\Couverture;
use App\Observers\BaseObserver;

class CouvertureObserver extends BaseObserver
{
    public function created(Couverture $couverture): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté couverture ID'.$couverture->id,
                'description' => 'Création de couverture ID'.$couverture->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$couverture->created_at->format('d/m/Y H:i'),
                'ligne' => $couverture->id,
                'table' => 'couvertures',
                'details' => $couverture,
                'api_route' => 'couverture.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Couverture $couverture): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié couverture ID'.$couverture->id,
                'description' => 'Modification de couverture ID'.$couverture->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$couverture->created_at->format('d/m/Y H:i'),
                'ligne' => $couverture->id,
                'table' => 'couvertures',
                'details' => [
                    'before' => $couverture->getOriginal(),
                    'after' => $couverture,
                ],
                'api_route' => 'couverture.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Couverture $couverture): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé couverture ID'.$couverture->id,
                'description' => 'Suppression de couverture ID'.$couverture->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$couverture->created_at->format('d/m/Y H:i'),
                'ligne' => $couverture->id,
                'table' => 'couvertures',
                'details' => $couverture,
                'api_route' => 'couverture.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Couverture $couverture): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré couverture ID'.$couverture->id,
                'description' => 'Restoration de couverture ID'.$couverture->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$couverture->created_at->format('d/m/Y H:i'),
                'ligne' => $couverture->id,
                'table' => 'couvertures',
                'details' => $couverture,
                'api_route' => 'couverture.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Couverture $couverture): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement couverture ID'.$couverture->id,
                'description' => 'Suppression définitive de couverture ID'.$couverture->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$couverture->created_at->format('d/m/Y H:i'),
                'ligne' => $couverture->id,
                'table' => 'couvertures',
                'details' => $couverture,
                'api_route' => 'couverture.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
