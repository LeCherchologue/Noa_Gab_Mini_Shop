<?php

namespace App\Observers;

use App\Models\Test;
use App\Observers\BaseObserver;

class TestObserver extends BaseObserver
{
    public function created(Test $test): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'ajouté test ID'.$test->id,
                'description' => 'Création de test ID'.$test->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$test->created_at->format('d/m/Y H:i'),
                'ligne' => $test->id,
                'table' => 'tests',
                'details' => $test,
                'api_route' => 'test.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function updated(Test $test): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'modifié test ID'.$test->id,
                'description' => 'Modification de test ID'.$test->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$test->created_at->format('d/m/Y H:i'),
                'ligne' => $test->id,
                'table' => 'tests',
                'details' => [
                    'before' => $test->getOriginal(),
                    'after' => $test,
                ],
                'api_route' => 'test.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function deleted(Test $test): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé test ID'.$test->id,
                'description' => 'Suppression de test ID'.$test->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$test->created_at->format('d/m/Y H:i'),
                'ligne' => $test->id,
                'table' => 'tests',
                'details' => $test,
                'api_route' => 'test.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function restored(Test $test): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'restoré test ID'.$test->id,
                'description' => 'Restoration de test ID'.$test->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$test->created_at->format('d/m/Y H:i'),
                'ligne' => $test->id,
                'table' => 'tests',
                'details' => $test,
                'api_route' => 'test.show',
            ];
            $this->storeActivity($activite);
        }
    }

    public function forceDeleted(Test $test): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            $activite = [
                'libelle' => 'supprimé définitivement test ID'.$test->id,
                'description' => 'Suppression définitive de test ID'.$test->id.' par l\'utilisateur '.auth('sanctum')->user()->name. ' le '.$test->created_at->format('d/m/Y H:i'),
                'ligne' => $test->id,
                'table' => 'tests',
                'details' => $test,
                'api_route' => 'test.show',
            ];
            $this->storeActivity($activite);
        }
    }
}
