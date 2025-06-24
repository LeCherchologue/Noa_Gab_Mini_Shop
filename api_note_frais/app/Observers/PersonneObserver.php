<?php

namespace App\Observers;

use App\Models\Personne;
use App\Observers\BaseObserver;

class PersonneObserver extends BaseObserver
{
    public function created(Personne $personne): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté personne ID'.$personne->id,
                'description' => 'Création de personne ID'.$personne->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$personne->created_at->format('d/m/Y H:i'),
                'ligne' => $personne->id,
                'table' => 'personnes',
                'details' => $personne,
                'api_route' => 'personne.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Personne $personne): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié personne ID'.$personne->id,
                'description' => 'Modification de personne ID'.$personne->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$personne->created_at->format('d/m/Y H:i'),
                'ligne' => $personne->id,
                'table' => 'personnes',
                'details' => [
                    'before' => $personne->getOriginal(),
                    'after' => $personne,
                ],
                'api_route' => 'personne.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Personne $personne): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé personne ID'.$personne->id,
                'description' => 'Suppression de personne ID'.$personne->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$personne->created_at->format('d/m/Y H:i'),
                'ligne' => $personne->id,
                'table' => 'personnes',
                'details' => $personne,
                'api_route' => 'personne.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Personne $personne): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré personne ID'.$personne->id,
                'description' => 'Restoration de personne ID'.$personne->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$personne->created_at->format('d/m/Y H:i'),
                'ligne' => $personne->id,
                'table' => 'personnes',
                'details' => $personne,
                'api_route' => 'personne.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Personne $personne): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement personne ID'.$personne->id,
                'description' => 'Suppression définitive de personne ID'.$personne->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$personne->created_at->format('d/m/Y H:i'),
                'ligne' => $personne->id,
                'table' => 'personnes',
                'details' => $personne,
                'api_route' => 'personne.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
