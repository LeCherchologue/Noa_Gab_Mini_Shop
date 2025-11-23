<?php

namespace App\Observers;

use App\Models\Contrat;
use App\Observers\BaseObserver;

class ContratObserver extends BaseObserver
{
    public function created(Contrat $contrat): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté contrat ID'.$contrat->id,
                'description' => 'Création de contrat ID'.$contrat->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$contrat->created_at->format('d/m/Y H:i'),
                'ligne' => $contrat->id,
                'table' => 'contrats',
                'details' => $contrat,
                'api_route' => 'contrat.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Contrat $contrat): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié contrat ID'.$contrat->id,
                'description' => 'Modification de contrat ID'.$contrat->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$contrat->created_at->format('d/m/Y H:i'),
                'ligne' => $contrat->id,
                'table' => 'contrats',
                'details' => [
                    'before' => $contrat->getOriginal(),
                    'after' => $contrat,
                ],
                'api_route' => 'contrat.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Contrat $contrat): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé contrat ID'.$contrat->id,
                'description' => 'Suppression de contrat ID'.$contrat->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$contrat->created_at->format('d/m/Y H:i'),
                'ligne' => $contrat->id,
                'table' => 'contrats',
                'details' => $contrat,
                'api_route' => 'contrat.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Contrat $contrat): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré contrat ID'.$contrat->id,
                'description' => 'Restoration de contrat ID'.$contrat->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$contrat->created_at->format('d/m/Y H:i'),
                'ligne' => $contrat->id,
                'table' => 'contrats',
                'details' => $contrat,
                'api_route' => 'contrat.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Contrat $contrat): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement contrat ID'.$contrat->id,
                'description' => 'Suppression définitive de contrat ID'.$contrat->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$contrat->created_at->format('d/m/Y H:i'),
                'ligne' => $contrat->id,
                'table' => 'contrats',
                'details' => $contrat,
                'api_route' => 'contrat.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
