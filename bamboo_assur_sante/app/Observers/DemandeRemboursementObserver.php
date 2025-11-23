<?php

namespace App\Observers;

use App\Models\DemandeRemboursement;
use App\Observers\BaseObserver;

class DemandeRemboursementObserver extends BaseObserver
{
    public function created(DemandeRemboursement $demande_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté demande_remboursement ID'.$demande_remboursement->id,
                'description' => 'Création de demande_remboursement ID'.$demande_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$demande_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $demande_remboursement->id,
                'table' => 'demande_remboursements',
                'details' => $demande_remboursement,
                'api_route' => 'demande_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(DemandeRemboursement $demande_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié demande_remboursement ID'.$demande_remboursement->id,
                'description' => 'Modification de demande_remboursement ID'.$demande_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$demande_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $demande_remboursement->id,
                'table' => 'demande_remboursements',
                'details' => [
                    'before' => $demande_remboursement->getOriginal(),
                    'after' => $demande_remboursement,
                ],
                'api_route' => 'demande_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(DemandeRemboursement $demande_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé demande_remboursement ID'.$demande_remboursement->id,
                'description' => 'Suppression de demande_remboursement ID'.$demande_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$demande_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $demande_remboursement->id,
                'table' => 'demande_remboursements',
                'details' => $demande_remboursement,
                'api_route' => 'demande_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(DemandeRemboursement $demande_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré demande_remboursement ID'.$demande_remboursement->id,
                'description' => 'Restoration de demande_remboursement ID'.$demande_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$demande_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $demande_remboursement->id,
                'table' => 'demande_remboursements',
                'details' => $demande_remboursement,
                'api_route' => 'demande_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(DemandeRemboursement $demande_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement demande_remboursement ID'.$demande_remboursement->id,
                'description' => 'Suppression définitive de demande_remboursement ID'.$demande_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$demande_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $demande_remboursement->id,
                'table' => 'demande_remboursements',
                'details' => $demande_remboursement,
                'api_route' => 'demande_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
