<?php

namespace App\Observers;

use App\Models\Paiement;
use App\Observers\BaseObserver;

class PaiementObserver extends BaseObserver
{
    public function created(Paiement $paiement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté paiement ID'.$paiement->id,
                'description' => 'Création de paiement ID'.$paiement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$paiement->created_at->format('d/m/Y H:i'),
                'ligne' => $paiement->id,
                'table' => 'paiements',
                'details' => $paiement,
                'api_route' => 'paiement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Paiement $paiement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié paiement ID'.$paiement->id,
                'description' => 'Modification de paiement ID'.$paiement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$paiement->created_at->format('d/m/Y H:i'),
                'ligne' => $paiement->id,
                'table' => 'paiements',
                'details' => [
                    'before' => $paiement->getOriginal(),
                    'after' => $paiement,
                ],
                'api_route' => 'paiement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Paiement $paiement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé paiement ID'.$paiement->id,
                'description' => 'Suppression de paiement ID'.$paiement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$paiement->created_at->format('d/m/Y H:i'),
                'ligne' => $paiement->id,
                'table' => 'paiements',
                'details' => $paiement,
                'api_route' => 'paiement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Paiement $paiement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré paiement ID'.$paiement->id,
                'description' => 'Restoration de paiement ID'.$paiement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$paiement->created_at->format('d/m/Y H:i'),
                'ligne' => $paiement->id,
                'table' => 'paiements',
                'details' => $paiement,
                'api_route' => 'paiement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Paiement $paiement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement paiement ID'.$paiement->id,
                'description' => 'Suppression définitive de paiement ID'.$paiement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$paiement->created_at->format('d/m/Y H:i'),
                'ligne' => $paiement->id,
                'table' => 'paiements',
                'details' => $paiement,
                'api_route' => 'paiement.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
