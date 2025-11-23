<?php

namespace App\Http\Controllers;
use App\Models\RegleRemboursement;
use App\Http\Resources\RegleRemboursementResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegleRemboursementController extends Controller
{

    public function index() 
    {
        $regle_remboursements = RegleRemboursement::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('regle_remboursements', $regle_remboursements)->count();

        return RegleRemboursementResource::collection($this->AsdecodefilterBy('regle_remboursements', $regle_remboursements));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'garantie_id' => 'required',
               //'plafond' => 'required',
               //'franchise' => 'required',
               //'taux_remboursement' => 'required',
           ],
           $messages = [
               //'garantie_id.required' => 'Le champ garantie_id ne peut etre vide',
               //'plafond.required' => 'Le champ plafond ne peut etre vide',
               //'franchise.required' => 'Le champ franchise ne peut etre vide',
               //'taux_remboursement.required' => 'Le champ taux_remboursement ne peut etre vide',
           ]
         );

        $regle_remboursements = RegleRemboursement::latest();
        if ($regle_remboursements
        ->where('garantie_id', $request->garantie_id)
        ->where('plafond', $request->plafond)
        ->where('franchise', $request->franchise)
        ->where('taux_remboursement', $request->taux_remboursement)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $regle_remboursement = RegleRemboursement::create($request->all());
        return $this->sendApiResponse($regle_remboursement, 'Regle_Remboursement ajouté', 201);
    }

    public function show($id)
    {
        return new RegleRemboursementResource(RegleRemboursement::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'garantie_id' => 'required',
               //'plafond' => 'required',
               //'franchise' => 'required',
               //'taux_remboursement' => 'required',
           ],
           $messages = [
               //'garantie_id.required' => 'Le champ garantie_id ne peut etre vide',
               //'plafond.required' => 'Le champ plafond ne peut etre vide',
               //'franchise.required' => 'Le champ franchise ne peut etre vide',
               //'taux_remboursement.required' => 'Le champ taux_remboursement ne peut etre vide',
           ]
         );

        $regle_remboursements = RegleRemboursement::latest();
        if ($regle_remboursements
        ->where('garantie_id', $request->garantie_id)
        ->where('plafond', $request->plafond)
        ->where('franchise', $request->franchise)
        ->where('taux_remboursement', $request->taux_remboursement)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $regle_remboursement = RegleRemboursement::find($id);
        $regle_remboursement->update($request->all());
        return $this->sendApiResponse($regle_remboursement, 'Regle_Remboursement modifié', 201);
    }

    public function destroy($id) 
    {
        $regle_remboursement = RegleRemboursement::find($id);
        $regle_remboursement->delete();

        return $this->sendApiResponse($regle_remboursement, 'Regle_Remboursement supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $regle_remboursement = RegleRemboursement::find($selected);
            if (isset($regle_remboursement)) {
                if ($regle_remboursement->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $regle_remboursement->delete();
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
