<?php

namespace App\Observers;

use App\Models\Garantie;
use App\Observers\BaseObserver;

class GarantieObserver extends BaseObserver
{
    public function created(Garantie $garantie): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté garantie ID'.$garantie->id,
                'description' => 'Création de garantie ID'.$garantie->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$garantie->created_at->format('d/m/Y H:i'),
                'ligne' => $garantie->id,
                'table' => 'garanties',
                'details' => $garantie,
                'api_route' => 'garantie.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Garantie $garantie): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié garantie ID'.$garantie->id,
                'description' => 'Modification de garantie ID'.$garantie->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$garantie->created_at->format('d/m/Y H:i'),
                'ligne' => $garantie->id,
                'table' => 'garanties',
                'details' => [
                    'before' => $garantie->getOriginal(),
                    'after' => $garantie,
                ],
                'api_route' => 'garantie.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Garantie $garantie): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé garantie ID'.$garantie->id,
                'description' => 'Suppression de garantie ID'.$garantie->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$garantie->created_at->format('d/m/Y H:i'),
                'ligne' => $garantie->id,
                'table' => 'garanties',
                'details' => $garantie,
                'api_route' => 'garantie.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Garantie $garantie): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré garantie ID'.$garantie->id,
                'description' => 'Restoration de garantie ID'.$garantie->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$garantie->created_at->format('d/m/Y H:i'),
                'ligne' => $garantie->id,
                'table' => 'garanties',
                'details' => $garantie,
                'api_route' => 'garantie.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Garantie $garantie): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement garantie ID'.$garantie->id,
                'description' => 'Suppression définitive de garantie ID'.$garantie->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$garantie->created_at->format('d/m/Y H:i'),
                'ligne' => $garantie->id,
                'table' => 'garanties',
                'details' => $garantie,
                'api_route' => 'garantie.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
