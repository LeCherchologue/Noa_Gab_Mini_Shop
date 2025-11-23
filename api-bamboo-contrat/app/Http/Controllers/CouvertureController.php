<?php

namespace App\Http\Controllers;
use App\Models\Couverture;
use App\Http\Resources\CouvertureResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouvertureController extends Controller
{

    public function index() 
    {
        $couvertures = Couverture::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('couvertures', $couvertures)->count();

        return CouvertureResource::collection($this->AsdecodefilterBy('couvertures', $couvertures));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'nom' => 'required',
               //'id_souscripteur' => 'required',
               //'duree' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'id_souscripteur.required' => 'Le champ id_souscripteur ne peut etre vide',
               //'duree.required' => 'Le champ duree ne peut etre vide',
           ]
         );

        $couvertures = Couverture::latest();
        if ($couvertures
        ->where('nom', $request->nom)
        ->where('id_souscripteur', $request->id_souscripteur)
        ->where('duree', $request->duree)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $couverture = Couverture::create($request->all());
        return $this->sendApiResponse($couverture, 'Couverture ajouté', 201);
    }

    public function show($id)
    {
        return new CouvertureResource(Couverture::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'nom' => 'required',
               //'id_souscripteur' => 'required',
               //'duree' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'id_souscripteur.required' => 'Le champ id_souscripteur ne peut etre vide',
               //'duree.required' => 'Le champ duree ne peut etre vide',
           ]
         );

        $couvertures = Couverture::latest();
        if ($couvertures
        ->where('nom', $request->nom)
        ->where('id_souscripteur', $request->id_souscripteur)
        ->where('duree', $request->duree)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $couverture = Couverture::find($id);
        $couverture->update($request->all());
        return $this->sendApiResponse($couverture, 'Couverture modifié', 201);
    }

    public function destroy($id) 
    {
        $couverture = Couverture::find($id);
        $couverture->delete();

        return $this->sendApiResponse($couverture, 'Couverture supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $couverture = Couverture::find($selected);
            if (isset($couverture)) {
                if ($couverture->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $couverture->delete();
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
