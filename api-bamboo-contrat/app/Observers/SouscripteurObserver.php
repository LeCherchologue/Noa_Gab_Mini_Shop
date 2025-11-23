<?php

namespace App\Observers;

use App\Models\Souscripteur;
use App\Observers\BaseObserver;

class SouscripteurObserver extends BaseObserver
{
    public function created(Souscripteur $souscripteur): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté souscripteur ID'.$souscripteur->id,
                'description' => 'Création de souscripteur ID'.$souscripteur->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$souscripteur->created_at->format('d/m/Y H:i'),
                'ligne' => $souscripteur->id,
                'table' => 'souscripteurs',
                'details' => $souscripteur,
                'api_route' => 'souscripteur.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Souscripteur $souscripteur): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié souscripteur ID'.$souscripteur->id,
                'description' => 'Modification de souscripteur ID'.$souscripteur->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$souscripteur->created_at->format('d/m/Y H:i'),
                'ligne' => $souscripteur->id,
                'table' => 'souscripteurs',
                'details' => [
                    'before' => $souscripteur->getOriginal(),
                    'after' => $souscripteur,
                ],
                'api_route' => 'souscripteur.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Souscripteur $souscripteur): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé souscripteur ID'.$souscripteur->id,
                'description' => 'Suppression de souscripteur ID'.$souscripteur->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$souscripteur->created_at->format('d/m/Y H:i'),
                'ligne' => $souscripteur->id,
                'table' => 'souscripteurs',
                'details' => $souscripteur,
                'api_route' => 'souscripteur.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Souscripteur $souscripteur): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré souscripteur ID'.$souscripteur->id,
                'description' => 'Restoration de souscripteur ID'.$souscripteur->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$souscripteur->created_at->format('d/m/Y H:i'),
                'ligne' => $souscripteur->id,
                'table' => 'souscripteurs',
                'details' => $souscripteur,
                'api_route' => 'souscripteur.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Souscripteur $souscripteur): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement souscripteur ID'.$souscripteur->id,
                'description' => 'Suppression définitive de souscripteur ID'.$souscripteur->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$souscripteur->created_at->format('d/m/Y H:i'),
                'ligne' => $souscripteur->id,
                'table' => 'souscripteurs',
                'details' => $souscripteur,
                'api_route' => 'souscripteur.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
