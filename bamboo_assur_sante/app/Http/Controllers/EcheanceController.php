<?php

namespace App\Http\Controllers;
use App\Models\Echeance;
use App\Http\Resources\EcheanceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EcheanceController extends Controller
{

    public function index() 
    {
        $echeances = Echeance::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('echeances', $echeances)->count();

        return EcheanceResource::collection($this->AsdecodefilterBy('echeances', $echeances));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'montant' => 'required',
               //'date_echeance' => 'required',
               //'date_reglement' => 'required',
               //'statut' => 'required',
               //'id_paiement' => 'required',
           ],
           $messages = [
               //'montant.required' => 'Le champ montant ne peut etre vide',
               //'date_echeance.required' => 'Le champ date_echeance ne peut etre vide',
               //'date_reglement.required' => 'Le champ date_reglement ne peut etre vide',
               //'statut.required' => 'Le champ statut ne peut etre vide',
               //'id_paiement.required' => 'Le champ id_paiement ne peut etre vide',
           ]
         );

        $echeances = Echeance::latest();
        if ($echeances
        ->where('montant', $request->montant)
        ->where('date_echeance', $request->date_echeance)
        ->where('date_reglement', $request->date_reglement)
        ->where('statut', $request->statut)
        ->where('id_paiement', $request->id_paiement)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $echeance = Echeance::create($request->all());
        return $this->sendApiResponse($echeance, 'Echeance ajouté', 201);
    }

    public function show($id)
    {
        return new EcheanceResource(Echeance::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'montant' => 'required',
               //'date_echeance' => 'required',
               //'date_reglement' => 'required',
               //'statut' => 'required',
               //'id_paiement' => 'required',
           ],
           $messages = [
               //'montant.required' => 'Le champ montant ne peut etre vide',
               //'date_echeance.required' => 'Le champ date_echeance ne peut etre vide',
               //'date_reglement.required' => 'Le champ date_reglement ne peut etre vide',
               //'statut.required' => 'Le champ statut ne peut etre vide',
               //'id_paiement.required' => 'Le champ id_paiement ne peut etre vide',
           ]
         );

        $echeances = Echeance::latest();
        if ($echeances
        ->where('montant', $request->montant)
        ->where('date_echeance', $request->date_echeance)
        ->where('date_reglement', $request->date_reglement)
        ->where('statut', $request->statut)
        ->where('id_paiement', $request->id_paiement)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $echeance = Echeance::find($id);
        $echeance->update($request->all());
        return $this->sendApiResponse($echeance, 'Echeance modifié', 201);
    }

    public function destroy($id) 
    {
        $echeance = Echeance::find($id);
        $echeance->delete();

        return $this->sendApiResponse($echeance, 'Echeance supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $echeance = Echeance::find($selected);
            if (isset($echeance)) {
                if ($echeance->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $echeance->delete();
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
