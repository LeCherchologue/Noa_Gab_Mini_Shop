<?php

namespace App\Http\Controllers;
use App\Models\Souscripteur;
use App\Http\Resources\SouscripteurResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SouscripteurController extends Controller
{

    public function index() 
    {
        $souscripteurs = Souscripteur::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('souscripteurs', $souscripteurs)->count();

        return SouscripteurResource::collection($this->AsdecodefilterBy('souscripteurs', $souscripteurs));
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
               //'beneficiaire' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'prenom.required' => 'Le champ prenom ne peut etre vide',
               //'tel.required' => 'Le champ tel ne peut etre vide',
               //'nb_enfant.required' => 'Le champ nb_enfant ne peut etre vide',
               //'assurance.required' => 'Le champ assurance ne peut etre vide',
               //'adresse.required' => 'Le champ adresse ne peut etre vide',
               //'beneficiaire.required' => 'Le champ beneficiaire ne peut etre vide',
           ]
         );

        $souscripteurs = Souscripteur::latest();
        if ($souscripteurs
        ->where('nom', $request->nom)
        ->where('prenom', $request->prenom)
        ->where('tel', $request->tel)
        ->where('nb_enfant', $request->nb_enfant)
        ->where('assurance', $request->assurance)
        ->where('adresse', $request->adresse)
        ->where('beneficiaire', $request->beneficiaire)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $souscripteur = Souscripteur::create($request->all());
        return $this->sendApiResponse($souscripteur, 'Souscripteur ajouté', 201);
    }

    public function show($id)
    {
        return new SouscripteurResource(Souscripteur::find($id));
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
               //'beneficiaire' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'prenom.required' => 'Le champ prenom ne peut etre vide',
               //'tel.required' => 'Le champ tel ne peut etre vide',
               //'nb_enfant.required' => 'Le champ nb_enfant ne peut etre vide',
               //'assurance.required' => 'Le champ assurance ne peut etre vide',
               //'adresse.required' => 'Le champ adresse ne peut etre vide',
               //'beneficiaire.required' => 'Le champ beneficiaire ne peut etre vide',
           ]
         );

        $souscripteurs = Souscripteur::latest();
        if ($souscripteurs
        ->where('nom', $request->nom)
        ->where('prenom', $request->prenom)
        ->where('tel', $request->tel)
        ->where('nb_enfant', $request->nb_enfant)
        ->where('assurance', $request->assurance)
        ->where('adresse', $request->adresse)
        ->where('beneficiaire', $request->beneficiaire)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $souscripteur = Souscripteur::find($id);
        $souscripteur->update($request->all());
        return $this->sendApiResponse($souscripteur, 'Souscripteur modifié', 201);
    }

    public function destroy($id) 
    {
        $souscripteur = Souscripteur::find($id);
        $souscripteur->delete();

        return $this->sendApiResponse($souscripteur, 'Souscripteur supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $souscripteur = Souscripteur::find($selected);
            if (isset($souscripteur)) {
                if ($souscripteur->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $souscripteur->delete();
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
