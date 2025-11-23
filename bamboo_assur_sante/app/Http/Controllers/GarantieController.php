<?php

namespace App\Http\Controllers;
use App\Models\Garantie;
use App\Http\Resources\GarantieResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GarantieController extends Controller
{

    public function index() 
    {
        $garanties = Garantie::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('garanties', $garanties)->count();

        return GarantieResource::collection($this->AsdecodefilterBy('garanties', $garanties));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'libelle' => 'required',
               //'description' => 'required',
               //'categorie' => 'required',
           ],
           $messages = [
               //'libelle.required' => 'Le champ libelle ne peut etre vide',
               //'description.required' => 'Le champ description ne peut etre vide',
               //'categorie.required' => 'Le champ categorie ne peut etre vide',
           ]
         );

        $garanties = Garantie::latest();
        if ($garanties
        ->where('libelle', $request->libelle)
        ->where('description', $request->description)
        ->where('categorie', $request->categorie)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $garantie = Garantie::create($request->all());
        return $this->sendApiResponse($garantie, 'Garantie ajouté', 201);
    }

    public function show($id)
    {
        return new GarantieResource(Garantie::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'libelle' => 'required',
               //'description' => 'required',
               //'categorie' => 'required',
           ],
           $messages = [
               //'libelle.required' => 'Le champ libelle ne peut etre vide',
               //'description.required' => 'Le champ description ne peut etre vide',
               //'categorie.required' => 'Le champ categorie ne peut etre vide',
           ]
         );

        $garanties = Garantie::latest();
        if ($garanties
        ->where('libelle', $request->libelle)
        ->where('description', $request->description)
        ->where('categorie', $request->categorie)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $garantie = Garantie::find($id);
        $garantie->update($request->all());
        return $this->sendApiResponse($garantie, 'Garantie modifié', 201);
    }

    public function destroy($id) 
    {
        $garantie = Garantie::find($id);
        $garantie->delete();

        return $this->sendApiResponse($garantie, 'Garantie supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $garantie = Garantie::find($selected);
            if (isset($garantie)) {
                if ($garantie->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $garantie->delete();
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
