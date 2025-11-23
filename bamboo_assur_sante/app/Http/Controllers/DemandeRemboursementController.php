<?php

namespace App\Http\Controllers;
use App\Models\DemandeRemboursement;
use App\Http\Resources\DemandeRemboursementResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DemandeRemboursementController extends Controller
{

    public function index() 
    {
        $demande_remboursements = DemandeRemboursement::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('demande_remboursements', $demande_remboursements)->count();

        return DemandeRemboursementResource::collection($this->AsdecodefilterBy('demande_remboursements', $demande_remboursements));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'contrat_id' => 'required',
               //'beneficiare_id' => 'required',
               //'reference' => 'required',
               //'date_reclamation' => 'required',
               //'statut' => 'required',
               //'total' => 'required',
               //'montant_rembourse' => 'required',
               //'motif_refus' => 'required',
           ],
           $messages = [
               //'contrat_id.required' => 'Le champ contrat_id ne peut etre vide',
               //'beneficiare_id.required' => 'Le champ beneficiare_id ne peut etre vide',
               //'reference.required' => 'Le champ reference ne peut etre vide',
               //'date_reclamation.required' => 'Le champ date_reclamation ne peut etre vide',
               //'statut.required' => 'Le champ statut ne peut etre vide',
               //'total.required' => 'Le champ total ne peut etre vide',
               //'montant_rembourse.required' => 'Le champ montant_rembourse ne peut etre vide',
               //'motif_refus.required' => 'Le champ motif_refus ne peut etre vide',
           ]
         );

        $demande_remboursements = DemandeRemboursement::latest();
        if ($demande_remboursements
        ->where('contrat_id', $request->contrat_id)
        ->where('beneficiare_id', $request->beneficiare_id)
        ->where('reference', $request->reference)
        ->where('date_reclamation', $request->date_reclamation)
        ->where('statut', $request->statut)
        ->where('total', $request->total)
        ->where('montant_rembourse', $request->montant_rembourse)
        ->where('motif_refus', $request->motif_refus)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $demande_remboursement = DemandeRemboursement::create($request->all());
        return $this->sendApiResponse($demande_remboursement, 'Demande_Remboursement ajouté', 201);
    }

    public function show($id)
    {
        return new DemandeRemboursementResource(DemandeRemboursement::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'contrat_id' => 'required',
               //'beneficiare_id' => 'required',
               //'reference' => 'required',
               //'date_reclamation' => 'required',
               //'statut' => 'required',
               //'total' => 'required',
               //'montant_rembourse' => 'required',
               //'motif_refus' => 'required',
           ],
           $messages = [
               //'contrat_id.required' => 'Le champ contrat_id ne peut etre vide',
               //'beneficiare_id.required' => 'Le champ beneficiare_id ne peut etre vide',
               //'reference.required' => 'Le champ reference ne peut etre vide',
               //'date_reclamation.required' => 'Le champ date_reclamation ne peut etre vide',
               //'statut.required' => 'Le champ statut ne peut etre vide',
               //'total.required' => 'Le champ total ne peut etre vide',
               //'montant_rembourse.required' => 'Le champ montant_rembourse ne peut etre vide',
               //'motif_refus.required' => 'Le champ motif_refus ne peut etre vide',
           ]
         );

        $demande_remboursements = DemandeRemboursement::latest();
        if ($demande_remboursements
        ->where('contrat_id', $request->contrat_id)
        ->where('beneficiare_id', $request->beneficiare_id)
        ->where('reference', $request->reference)
        ->where('date_reclamation', $request->date_reclamation)
        ->where('statut', $request->statut)
        ->where('total', $request->total)
        ->where('montant_rembourse', $request->montant_rembourse)
        ->where('motif_refus', $request->motif_refus)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $demande_remboursement = DemandeRemboursement::find($id);
        $demande_remboursement->update($request->all());
        return $this->sendApiResponse($demande_remboursement, 'Demande_Remboursement modifié', 201);
    }

    public function destroy($id) 
    {
        $demande_remboursement = DemandeRemboursement::find($id);
        $demande_remboursement->delete();

        return $this->sendApiResponse($demande_remboursement, 'Demande_Remboursement supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $demande_remboursement = DemandeRemboursement::find($selected);
            if (isset($demande_remboursement)) {
                if ($demande_remboursement->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $demande_remboursement->delete();
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
