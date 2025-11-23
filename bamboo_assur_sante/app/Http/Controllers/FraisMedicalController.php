<?php

namespace App\Http\Controllers;
use App\Models\FraisMedical;
use App\Http\Resources\FraisMedicalResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FraisMedicalController extends Controller
{

    public function index() 
    {
        $frais_medicals = FraisMedical::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('frais_medicals', $frais_medicals)->count();

        return FraisMedicalResource::collection($this->AsdecodefilterBy('frais_medicals', $frais_medicals));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'demande_remboursement_id' => 'required',
               //'type_frais' => 'required',
               //'montant' => 'required',
               //'description' => 'required',
               //'justificatif' => 'required',
           ],
           $messages = [
               //'demande_remboursement_id.required' => 'Le champ demande_remboursement_id ne peut etre vide',
               //'type_frais.required' => 'Le champ type_frais ne peut etre vide',
               //'montant.required' => 'Le champ montant ne peut etre vide',
               //'description.required' => 'Le champ description ne peut etre vide',
               //'justificatif.required' => 'Le champ justificatif ne peut etre vide',
           ]
         );

        $frais_medicals = FraisMedical::latest();
        if ($frais_medicals
        ->where('demande_remboursement_id', $request->demande_remboursement_id)
        ->where('type_frais', $request->type_frais)
        ->where('montant', $request->montant)
        ->where('description', $request->description)
        ->where('justificatif', $request->justificatif)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $frais_medical = FraisMedical::create($request->all());
        return $this->sendApiResponse($frais_medical, 'Frais_Medical ajouté', 201);
    }

    public function show($id)
    {
        return new FraisMedicalResource(FraisMedical::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'demande_remboursement_id' => 'required',
               //'type_frais' => 'required',
               //'montant' => 'required',
               //'description' => 'required',
               //'justificatif' => 'required',
           ],
           $messages = [
               //'demande_remboursement_id.required' => 'Le champ demande_remboursement_id ne peut etre vide',
               //'type_frais.required' => 'Le champ type_frais ne peut etre vide',
               //'montant.required' => 'Le champ montant ne peut etre vide',
               //'description.required' => 'Le champ description ne peut etre vide',
               //'justificatif.required' => 'Le champ justificatif ne peut etre vide',
           ]
         );

        $frais_medicals = FraisMedical::latest();
        if ($frais_medicals
        ->where('demande_remboursement_id', $request->demande_remboursement_id)
        ->where('type_frais', $request->type_frais)
        ->where('montant', $request->montant)
        ->where('description', $request->description)
        ->where('justificatif', $request->justificatif)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $frais_medical = FraisMedical::find($id);
        $frais_medical->update($request->all());
        return $this->sendApiResponse($frais_medical, 'Frais_Medical modifié', 201);
    }

    public function destroy($id) 
    {
        $frais_medical = FraisMedical::find($id);
        $frais_medical->delete();

        return $this->sendApiResponse($frais_medical, 'Frais_Medical supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $frais_medical = FraisMedical::find($selected);
            if (isset($frais_medical)) {
                if ($frais_medical->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $frais_medical->delete();
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
