<?php

namespace App\Http\Controllers;
use App\Models\Paiement;
use App\Http\Resources\PaiementResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaiementController extends Controller
{

    public function index() 
    {
        $paiements = Paiement::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('paiements', $paiements)->count();

        return PaiementResource::collection($this->AsdecodefilterBy('paiements', $paiements));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'reference' => 'required',
               //'montant_total' => 'required',
               //'type_paiement' => 'required',
               //'statut' => 'required',
               //'moyen_paiement' => 'required',
               //'date_paiement' => 'required',
               //'id_contrat' => 'required',
               //'client_bamboo_emf' => 'required',
           ],
           $messages = [
               //'reference.required' => 'Le champ reference ne peut etre vide',
               //'montant_total.required' => 'Le champ montant_total ne peut etre vide',
               //'type_paiement.required' => 'Le champ type_paiement ne peut etre vide',
               //'statut.required' => 'Le champ statut ne peut etre vide',
               //'moyen_paiement.required' => 'Le champ moyen_paiement ne peut etre vide',
               //'date_paiement.required' => 'Le champ date_paiement ne peut etre vide',
               //'id_contrat.required' => 'Le champ id_contrat ne peut etre vide',
               //'client_bamboo_emf.required' => 'Le champ client_bamboo_emf ne peut etre vide',
           ]
         );

        $paiements = Paiement::latest();
        if ($paiements
        ->where('reference', $request->reference)
        ->where('montant_total', $request->montant_total)
        ->where('type_paiement', $request->type_paiement)
        ->where('statut', $request->statut)
        ->where('moyen_paiement', $request->moyen_paiement)
        ->where('date_paiement', $request->date_paiement)
        ->where('id_contrat', $request->id_contrat)
        ->where('client_bamboo_emf', $request->client_bamboo_emf)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $paiement = Paiement::create($request->all());
        return $this->sendApiResponse($paiement, 'Paiement ajouté', 201);
    }

    public function show($id)
    {
        return new PaiementResource(Paiement::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'reference' => 'required',
               //'montant_total' => 'required',
               //'type_paiement' => 'required',
               //'statut' => 'required',
               //'moyen_paiement' => 'required',
               //'date_paiement' => 'required',
               //'id_contrat' => 'required',
               //'client_bamboo_emf' => 'required',
           ],
           $messages = [
               //'reference.required' => 'Le champ reference ne peut etre vide',
               //'montant_total.required' => 'Le champ montant_total ne peut etre vide',
               //'type_paiement.required' => 'Le champ type_paiement ne peut etre vide',
               //'statut.required' => 'Le champ statut ne peut etre vide',
               //'moyen_paiement.required' => 'Le champ moyen_paiement ne peut etre vide',
               //'date_paiement.required' => 'Le champ date_paiement ne peut etre vide',
               //'id_contrat.required' => 'Le champ id_contrat ne peut etre vide',
               //'client_bamboo_emf.required' => 'Le champ client_bamboo_emf ne peut etre vide',
           ]
         );

        $paiements = Paiement::latest();
        if ($paiements
        ->where('reference', $request->reference)
        ->where('montant_total', $request->montant_total)
        ->where('type_paiement', $request->type_paiement)
        ->where('statut', $request->statut)
        ->where('moyen_paiement', $request->moyen_paiement)
        ->where('date_paiement', $request->date_paiement)
        ->where('id_contrat', $request->id_contrat)
        ->where('client_bamboo_emf', $request->client_bamboo_emf)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $paiement = Paiement::find($id);
        $paiement->update($request->all());
        return $this->sendApiResponse($paiement, 'Paiement modifié', 201);
    }

    public function destroy($id) 
    {
        $paiement = Paiement::find($id);
        $paiement->delete();

        return $this->sendApiResponse($paiement, 'Paiement supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $paiement = Paiement::find($selected);
            if (isset($paiement)) {
                if ($paiement->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $paiement->delete();
                    $nb_supprimes++;
                    $messages[$key] = [
                        'severity' => 'success',
                        'value' => $nb_supprimes.' lignes ont été supprimé'
                    ];
                }
            }
        }
        return $this->sendApiResponse([], $messages);
    }

}
