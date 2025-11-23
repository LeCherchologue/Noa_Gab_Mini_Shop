<?php

namespace App\Http\Controllers;
use App\Models\Beneficiaire;
use App\Http\Resources\BeneficiaireResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeneficiaireController extends Controller
{

    public function index() 
    {
        $beneficiaires = Beneficiaire::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('beneficiaires', $beneficiaires)->count();

        return BeneficiaireResource::collection($this->AsdecodefilterBy('beneficiaires', $beneficiaires));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'nom' => 'required',
               //'prenom' => 'required',
               //'tel' => 'required',
               //'nb_enfant' => 'required',
               //'assurance' => 'required',
               //'adresse' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'prenom.required' => 'Le champ prenom ne peut etre vide',
               //'tel.required' => 'Le champ tel ne peut etre vide',
               //'nb_enfant.required' => 'Le champ nb_enfant ne peut etre vide',
               //'assurance.required' => 'Le champ assurance ne peut etre vide',
               //'adresse.required' => 'Le champ adresse ne peut etre vide',
           ]
         );

        $beneficiaires = Beneficiaire::latest();
        if ($beneficiaires
        ->where('nom', $request->nom)
        ->where('prenom', $request->prenom)
        ->where('tel', $request->tel)
        ->where('nb_enfant', $request->nb_enfant)
        ->where('assurance', $request->assurance)
        ->where('adresse', $request->adresse)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $beneficiaire = Beneficiaire::create($request->all());
        return $this->sendApiResponse($beneficiaire, 'Beneficiaire ajouté', 201);
    }

    public function show($id)
    {
        return new BeneficiaireResource(Beneficiaire::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'nom' => 'required',
               //'prenom' => 'required',
               //'tel' => 'required',
               //'nb_enfant' => 'required',
               //'assurance' => 'required',
               //'adresse' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'prenom.required' => 'Le champ prenom ne peut etre vide',
               //'tel.required' => 'Le champ tel ne peut etre vide',
               //'nb_enfant.required' => 'Le champ nb_enfant ne peut etre vide',
               //'assurance.required' => 'Le champ assurance ne peut etre vide',
               //'adresse.required' => 'Le champ adresse ne peut etre vide',
           ]
         );

        $beneficiaires = Beneficiaire::latest();
        if ($beneficiaires
        ->where('nom', $request->nom)
        ->where('prenom', $request->prenom)
        ->where('tel', $request->tel)
        ->where('nb_enfant', $request->nb_enfant)
        ->where('assurance', $request->assurance)
        ->where('adresse', $request->adresse)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $beneficiaire = Beneficiaire::find($id);
        $beneficiaire->update($request->all());
        return $this->sendApiResponse($beneficiaire, 'Beneficiaire modifié', 201);
    }

    public function destroy($id) 
    {
        $beneficiaire = Beneficiaire::find($id);
        $beneficiaire->delete();

        return $this->sendApiResponse($beneficiaire, 'Beneficiaire supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $beneficiaire = Beneficiaire::find($selected);
            if (isset($beneficiaire)) {
                if ($beneficiaire->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $beneficiaire->delete();
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
