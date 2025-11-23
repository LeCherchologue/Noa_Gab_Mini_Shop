<?php

namespace App\Observers;

use App\Models\FraisMedical;
use App\Observers\BaseObserver;

class FraisMedicalObserver extends BaseObserver
{
    public function created(FraisMedical $frais_medical): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté frais_medical ID'.$frais_medical->id,
                'description' => 'Création de frais_medical ID'.$frais_medical->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frais_medical->created_at->format('d/m/Y H:i'),
                'ligne' => $frais_medical->id,
                'table' => 'frais_medicals',
                'details' => $frais_medical,
                'api_route' => 'frais_medical.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(FraisMedical $frais_medical): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié frais_medical ID'.$frais_medical->id,
                'description' => 'Modification de frais_medical ID'.$frais_medical->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frais_medical->created_at->format('d/m/Y H:i'),
                'ligne' => $frais_medical->id,
                'table' => 'frais_medicals',
                'details' => [
                    'before' => $frais_medical->getOriginal(),
                    'after' => $frais_medical,
                ],
                'api_route' => 'frais_medical.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(FraisMedical $frais_medical): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé frais_medical ID'.$frais_medical->id,
                'description' => 'Suppression de frais_medical ID'.$frais_medical->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frais_medical->created_at->format('d/m/Y H:i'),
                'ligne' => $frais_medical->id,
                'table' => 'frais_medicals',
                'details' => $frais_medical,
                'api_route' => 'frais_medical.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(FraisMedical $frais_medical): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré frais_medical ID'.$frais_medical->id,
                'description' => 'Restoration de frais_medical ID'.$frais_medical->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frais_medical->created_at->format('d/m/Y H:i'),
                'ligne' => $frais_medical->id,
                'table' => 'frais_medicals',
                'details' => $frais_medical,
                'api_route' => 'frais_medical.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(FraisMedical $frais_medical): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement frais_medical ID'.$frais_medical->id,
                'description' => 'Suppression définitive de frais_medical ID'.$frais_medical->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$frais_medical->created_at->format('d/m/Y H:i'),
                'ligne' => $frais_medical->id,
                'table' => 'frais_medicals',
                'details' => $frais_medical,
                'api_route' => 'frais_medical.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
