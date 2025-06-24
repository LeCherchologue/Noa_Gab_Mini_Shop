<?php

namespace App\Http\Controllers;
use App\Models\Test;
use App\Http\Resources\TestResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{

    public function index() 
    {
        $tests = Test::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('tests', $tests)->count();

        return TestResource::collection($this->AsdecodefilterBy('tests', $tests));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'nom' => 'required',
               //'prenom' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'prenom.required' => 'Le champ prenom ne peut etre vide',
           ]
         );

        $tests = Test::latest();
        if ($tests
        ->where('nom', $request->nom)
        ->where('prenom', $request->prenom)
        ->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $test = Test::create($request->all());
        return $this->sendApiResponse($test, 'Test ajouté', 201);
    }

    public function show($id)
    {
        return new TestResource(Test::find($id));
    }

    public function update(Request $request, $id) 
    {
        $validator = Validator::make(
           $request->all(),
           [
               //'nom' => 'required',
               //'prenom' => 'required',
           ],
           $messages = [
               //'nom.required' => 'Le champ nom ne peut etre vide',
               //'prenom.required' => 'Le champ prenom ne peut etre vide',
           ]
         );

        $tests = Test::latest();
        if ($tests
        ->where('nom', $request->nom)
        ->where('prenom', $request->prenom)
        ->where('id','!=', $id)->first()) {
           $messages = [ 'Cet enregistrement existe déjà' ];
           return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $test = Test::find($id);
        $test->update($request->all());
        return $this->sendApiResponse($test, 'Test modifié', 201);
    }

    public function destroy($id) 
    {
        $test = Test::find($id);
        $test->delete();

        return $this->sendApiResponse($test, 'Test supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages= [];
        foreach ($request->selected_lines as $selected) {
            $test = Test::find($selected);
            if (isset($test)) {
                if ($test->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0'.$selected
                    ];
                    $key++;
                }
                else {
                    $test->delete();
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
