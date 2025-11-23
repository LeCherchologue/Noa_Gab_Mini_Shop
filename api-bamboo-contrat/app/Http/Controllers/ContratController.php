<?php

namespace App\Http\Controllers;
use App\Models\Contrat;
use App\Http\Resources\ContratResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContratController extends Controller
{

    public function index() 
    {
        $contrats = Contrat::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('contrats', $contrats)->count();

        return ContratResource::collection($this->AsdecodefilterBy('contrats', $contrats));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'date_debut' => 'required',
               //'date_fin' => 'required',
               //'mode_paiement' => 'required',
               //'tiers_payant' => 'required',
               //'id_souscripteur' => 'required',
           ],
           $messages = [
               //'date_debut.required' => 'Le champ date_debut ne peut etre vide',
               //'date_fin.required' => 'Le champ date_fin ne peut etre vide',
               //'mode_paiement.required' => 'Le champ mode_paiement ne peut etre vide',
               //'tiers_payant.required' => 'Le champ tiers_payant ne peut etre vide',
               //'id_souscripteur.required' => 'Le champ id_souscripteur ne peut etre vide',
           ]
         );

        $contrats = Contrat::latest();
        if ($contrats
        ->where('date_debut', $request->date_debut)
        ->where('date_fin', $request->date_fin)
        ->where('mode_paiement', $request->mode_paiement)
        ->where('tiers_payant', $request->tiers_payant)
        ->where('id_souscripteur', $request->id_souscripteur)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $contrat = Contrat::create($request->all());
        return $this->sendApiResponse($contrat, 'Contrat ajouté', 201);
    }

    public function show($id)
    {
        return new ContratResource(Contrat::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'date_debut' => 'required',
               //'date_fin' => 'required',
               //'mode_paiement' => 'required',
               //'tiers_payant' => 'required',
               //'id_souscripteur' => 'required',
           ],
           $messages = [
               //'date_debut.required' => 'Le champ date_debut ne peut etre vide',
               //'date_fin.required' => 'Le champ date_fin ne peut etre vide',
               //'mode_paiement.required' => 'Le champ mode_paiement ne peut etre vide',
               //'tiers_payant.required' => 'Le champ tiers_payant ne peut etre vide',
               //'id_souscripteur.required' => 'Le champ id_souscripteur ne peut etre vide',
           ]
         );

        $contrats = Contrat::latest();
        if ($contrats
        ->where('date_debut', $request->date_debut)
        ->where('date_fin', $request->date_fin)
        ->where('mode_paiement', $request->mode_paiement)
        ->where('tiers_payant', $request->tiers_payant)
        ->where('id_souscripteur', $request->id_souscripteur)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $contrat = Contrat::find($id);
        $contrat->update($request->all());
        return $this->sendApiResponse($contrat, 'Contrat modifié', 201);
    }

    public function destroy($id) 
    {
        $contrat = Contrat::find($id);
        $contrat->delete();

        return $this->sendApiResponse($contrat, 'Contrat supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $contrat = Contrat::find($selected);
            if (isset($contrat)) {
                if ($contrat->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $contrat->delete();
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
