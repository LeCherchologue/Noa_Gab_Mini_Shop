<?php

namespace App\Observers;

use App\Models\Echeance;
use App\Observers\BaseObserver;

class EcheanceObserver extends BaseObserver
{
    public function created(Echeance $echeance): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté echeance ID'.$echeance->id,
                'description' => 'Création de echeance ID'.$echeance->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$echeance->created_at->format('d/m/Y H:i'),
                'ligne' => $echeance->id,
                'table' => 'echeances',
                'details' => $echeance,
                'api_route' => 'echeance.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Echeance $echeance): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié echeance ID'.$echeance->id,
                'description' => 'Modification de echeance ID'.$echeance->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$echeance->created_at->format('d/m/Y H:i'),
                'ligne' => $echeance->id,
                'table' => 'echeances',
                'details' => [
                    'before' => $echeance->getOriginal(),
                    'after' => $echeance,
                ],
                'api_route' => 'echeance.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Echeance $echeance): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé echeance ID'.$echeance->id,
                'description' => 'Suppression de echeance ID'.$echeance->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$echeance->created_at->format('d/m/Y H:i'),
                'ligne' => $echeance->id,
                'table' => 'echeances',
                'details' => $echeance,
                'api_route' => 'echeance.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Echeance $echeance): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré echeance ID'.$echeance->id,
                'description' => 'Restoration de echeance ID'.$echeance->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$echeance->created_at->format('d/m/Y H:i'),
                'ligne' => $echeance->id,
                'table' => 'echeances',
                'details' => $echeance,
                'api_route' => 'echeance.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Echeance $echeance): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement echeance ID'.$echeance->id,
                'description' => 'Suppression définitive de echeance ID'.$echeance->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$echeance->created_at->format('d/m/Y H:i'),
                'ligne' => $echeance->id,
                'table' => 'echeances',
                'details' => $echeance,
                'api_route' => 'echeance.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
