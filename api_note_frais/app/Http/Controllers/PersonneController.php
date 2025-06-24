<?php

namespace App\Http\Controllers;
use App\Models\Personne;
use App\Http\Resources\PersonneResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonneController extends Controller
{

    public function index() 
    {
        $personnes = Personne::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('personnes', $personnes)->count();

        return PersonneResource::collection($this->AsdecodefilterBy('personnes', $personnes));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'nom' => 'required',
               //'prenom' => 'required',
               //'email' => 'required',
               //'phone' => 'required',
               //'mdp' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'prenom.required' => 'Le champ prenom ne peut etre vide',
               //'email.required' => 'Le champ email ne peut etre vide',
               //'phone.required' => 'Le champ phone ne peut etre vide',
               //'mdp.required' => 'Le champ mdp ne peut etre vide',
           ]
         );

        $personnes = Personne::latest();
        if ($personnes
        ->where('nom', $request->nom)
        ->where('prenom', $request->prenom)
        ->where('email', $request->email)
        ->where('phone', $request->phone)
        ->where('mdp', $request->mdp)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $personne = Personne::create($request->all());
        return $this->sendApiResponse($personne, 'Personne ajouté', 201);
    }

    public function show($id)
    {
        return new PersonneResource(Personne::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'nom' => 'required',
               //'prenom' => 'required',
               //'email' => 'required',
               //'phone' => 'required',
               //'mdp' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'prenom.required' => 'Le champ prenom ne peut etre vide',
               //'email.required' => 'Le champ email ne peut etre vide',
               //'phone.required' => 'Le champ phone ne peut etre vide',
               //'mdp.required' => 'Le champ mdp ne peut etre vide',
           ]
         );

        $personnes = Personne::latest();
        if ($personnes
        ->where('nom', $request->nom)
        ->where('prenom', $request->prenom)
        ->where('email', $request->email)
        ->where('phone', $request->phone)
        ->where('mdp', $request->mdp)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $personne = Personne::find($id);
        $personne->update($request->all());
        return $this->sendApiResponse($personne, 'Personne modifié', 201);
    }

    public function destroy($id) 
    {
        $personne = Personne::find($id);
        $personne->delete();

        return $this->sendApiResponse($personne, 'Personne supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $personne = Personne::find($selected);
            if (isset($personne)) {
                if ($personne->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $personne->delete();
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
