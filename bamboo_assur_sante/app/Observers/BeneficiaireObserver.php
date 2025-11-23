<?php

namespace App\Observers;

use App\Models\Beneficiaire;
use App\Observers\BaseObserver;

class BeneficiaireObserver extends BaseObserver
{
    public function created(Beneficiaire $beneficiaire): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté beneficiaire ID'.$beneficiaire->id,
                'description' => 'Création de beneficiaire ID'.$beneficiaire->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$beneficiaire->created_at->format('d/m/Y H:i'),
                'ligne' => $beneficiaire->id,
                'table' => 'beneficiaires',
                'details' => $beneficiaire,
                'api_route' => 'beneficiaire.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Beneficiaire $beneficiaire): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié beneficiaire ID'.$beneficiaire->id,
                'description' => 'Modification de beneficiaire ID'.$beneficiaire->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$beneficiaire->created_at->format('d/m/Y H:i'),
                'ligne' => $beneficiaire->id,
                'table' => 'beneficiaires',
                'details' => [
                    'before' => $beneficiaire->getOriginal(),
                    'after' => $beneficiaire,
                ],
                'api_route' => 'beneficiaire.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Beneficiaire $beneficiaire): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé beneficiaire ID'.$beneficiaire->id,
                'description' => 'Suppression de beneficiaire ID'.$beneficiaire->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$beneficiaire->created_at->format('d/m/Y H:i'),
                'ligne' => $beneficiaire->id,
                'table' => 'beneficiaires',
                'details' => $beneficiaire,
                'api_route' => 'beneficiaire.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Beneficiaire $beneficiaire): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré beneficiaire ID'.$beneficiaire->id,
                'description' => 'Restoration de beneficiaire ID'.$beneficiaire->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$beneficiaire->created_at->format('d/m/Y H:i'),
                'ligne' => $beneficiaire->id,
                'table' => 'beneficiaires',
                'details' => $beneficiaire,
                'api_route' => 'beneficiaire.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Beneficiaire $beneficiaire): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement beneficiaire ID'.$beneficiaire->id,
                'description' => 'Suppression définitive de beneficiaire ID'.$beneficiaire->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$beneficiaire->created_at->format('d/m/Y H:i'),
                'ligne' => $beneficiaire->id,
                'table' => 'beneficiaires',
                'details' => $beneficiaire,
                'api_route' => 'beneficiaire.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
