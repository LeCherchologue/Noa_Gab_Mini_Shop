<?php

namespace App\Observers;

use App\Models\RegleRemboursement;
use App\Observers\BaseObserver;

class RegleRemboursementObserver extends BaseObserver
{
    public function created(RegleRemboursement $regle_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté regle_remboursement ID'.$regle_remboursement->id,
                'description' => 'Création de regle_remboursement ID'.$regle_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$regle_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $regle_remboursement->id,
                'table' => 'regle_remboursements',
                'details' => $regle_remboursement,
                'api_route' => 'regle_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(RegleRemboursement $regle_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié regle_remboursement ID'.$regle_remboursement->id,
                'description' => 'Modification de regle_remboursement ID'.$regle_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$regle_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $regle_remboursement->id,
                'table' => 'regle_remboursements',
                'details' => [
                    'before' => $regle_remboursement->getOriginal(),
                    'after' => $regle_remboursement,
                ],
                'api_route' => 'regle_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(RegleRemboursement $regle_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé regle_remboursement ID'.$regle_remboursement->id,
                'description' => 'Suppression de regle_remboursement ID'.$regle_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$regle_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $regle_remboursement->id,
                'table' => 'regle_remboursements',
                'details' => $regle_remboursement,
                'api_route' => 'regle_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(RegleRemboursement $regle_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré regle_remboursement ID'.$regle_remboursement->id,
                'description' => 'Restoration de regle_remboursement ID'.$regle_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$regle_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $regle_remboursement->id,
                'table' => 'regle_remboursements',
                'details' => $regle_remboursement,
                'api_route' => 'regle_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(RegleRemboursement $regle_remboursement): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement regle_remboursement ID'.$regle_remboursement->id,
                'description' => 'Suppression définitive de regle_remboursement ID'.$regle_remboursement->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$regle_remboursement->created_at->format('d/m/Y H:i'),
                'ligne' => $regle_remboursement->id,
                'table' => 'regle_remboursements',
                'details' => $regle_remboursement,
                'api_route' => 'regle_remboursement.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
