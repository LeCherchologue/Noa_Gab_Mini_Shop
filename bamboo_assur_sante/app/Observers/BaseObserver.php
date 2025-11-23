<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Activite;
use App\Notifications\StandartNotification;

class BaseObserver
{
    public function storeActivity($activite): void
    {
        if (isset(auth('sanctum')->user()->id)) {
            //On enregistre l'action sur un element par l' utilisateur connecté
            $observe = Activite::create([
                'libelle' => $activite['libelle'],
                'description' => $activite['description'],
                'ligne' => $activite['ligne'],
                'table' => $activite['table'],
                'details' => json_encode($activite['details']),
                'api_route' => $activite['api_route'],
                'user_id' => auth('sanctum')->user()->id,
            ]);

            if ($this->tableIsNotifiable($activite['table'])) {
                $this->notifyAdmins($observe, ['database']);
            }
        }
    }

    public function checkPeriodState($debut, $echeance = null)
    {
        //on note la date actuelle
        $date_actuelle = now()->format('Y-m-d');

        if ((isset($debut)) && (isset($echeance)) && ($echeance != null)) {
            $date_debut = date(('Y-m-d'), strtotime($debut));
            $date_fin = date(('Y-m-d'), strtotime($echeance));

            //si c'est aujourd'hui ou avant aujourd'hui
            if (($date_debut < $date_actuelle) || ($date_debut == $date_actuelle)) {
                if ($date_fin < $date_actuelle) {
                    return 'Terminé';
                } else return 'En cours';
            } else return 'Programmé';
        } else return 'Brouillon';
    }

    public function notifyAdmins($observe, $via = ['mail', 'database']): void
    {
        //notifier les administrateurs mais pas l'auteur de l'activité
        $admins = User::where('is_admin', 1)->get();
        foreach ($admins as $admin) {
            if ($admin->id !== $observe->user_id) $admin->notify(new StandartNotification($observe, $via));
        }
    }

    private function tableIsNotifiable($observe)
    {
        $tables = [];

        foreach ($tables as $table) {
            if ($observe == $table) {
                return true;
            }
        }

        return false;
    }
}
