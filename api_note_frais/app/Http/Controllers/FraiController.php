<?php

namespace App\Http\Controllers;

use App\Models\Frai;
use App\Http\Resources\FraiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FraiController extends Controller
{

    public function index()
    {
        $frais = Frai::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('frais', $frais)->count();

        return FraiResource::collection($this->AsdecodefilterBy('frais', $frais));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                //'dates' => 'required',
                //'montant' => 'required',
                //'lieu' => 'required',
                //'divers' => 'required',
                //'user_id' => 'required',
            ],
            $messages = [
                //'dates.required' => 'Le champ dates ne peut etre vide',
                //'montant.required' => 'Le champ montant ne peut etre vide',
                //'lieu.required' => 'Le champ lieu ne peut etre vide',
                //'divers.required' => 'Le champ divers ne peut etre vide',
                //'user_id.required' => 'Le champ user_id ne peut etre vide',
            ]
        );

        $frais = Frai::latest();
        if ($frais
            ->where('dates', $request->dates)
            ->where('montant', $request->montant)
            ->where('lieu', $request->lieu)
            ->where('divers', $request->divers)
            ->where('user_id', $request->user_id)
            ->first()
        ) {
            $messages = ['Cet enregistrement existe déjà'];
            return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $frai = Frai::create($request->all());
        return $this->sendApiResponse($frai, 'Frai ajouté', 201);
    }

    public function show($id)
    {
        return new FraiResource(Frai::find($id));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                //'dates' => 'required',
                //'montant' => 'required',
                //'lieu' => 'required',
                //'divers' => 'required',
                //'user_id' => 'required',
            ],
            $messages = [
                //'dates.required' => 'Le champ dates ne peut etre vide',
                //'montant.required' => 'Le champ montant ne peut etre vide',
                //'lieu.required' => 'Le champ lieu ne peut etre vide',
                //'divers.required' => 'Le champ divers ne peut etre vide',
                //'user_id.required' => 'Le champ user_id ne peut etre vide',
            ]
        );

        $frais = Frai::latest();
        if ($frais
            ->where('dates', $request->dates)
            ->where('montant', $request->montant)
            ->where('lieu', $request->lieu)
            ->where('divers', $request->divers)
            ->where('user_id', $request->user_id)
            ->where('id', '!=', $id)->first()
        ) {
            $messages = ['Cet enregistrement existe déjà'];
            return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $frai = Frai::find($id);
        $frai->update($request->all());
        return $this->sendApiResponse($frai, 'Frai modifié', 201);
    }

    public function destroy($id)
    {
        $frai = Frai::find($id);
        $frai->delete();

        return $this->sendApiResponse($frai, 'Frai supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages = [];
        foreach ($request->selected_lines as $selected) {
            $frai = Frai::find($selected);
            if (isset($frai)) {
                if ($frai->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0' . $selected
                    ];
                    $key++;
                } else {
                    $frai->delete();
                    $nb_supprimes++;
                    $messages[$key] = [
                        'severity' => 'success',
                        'value' => $nb_supprimes . ' lignes ont été supprimé'
                    ];
                }
            }
        }
        return $this->sendApiResponse([], $messages);
    }
}
