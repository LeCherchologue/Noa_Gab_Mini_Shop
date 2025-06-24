<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\StandartMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::latest();

        if (isset($_GET['req_count'])) return $this->filterByColumn('users', $users)->count();

        return UserResource::collection($this->AsdecodefilterBy('users', $users));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                //'name' => 'required',
                //'prenom' => 'required',
                //'email' => 'required',
                //'password' => 'required',
                //'tel' => 'required',
            ],
            $messages = [
                //'name.required' => 'Le champ name ne peut etre vide',
                //'prenom.required' => 'Le champ prenom ne peut etre vide',
                //'email.required' => 'Le champ email ne peut etre vide',
                //'password.required' => 'Le champ password ne peut etre vide',
                //'tel.required' => 'Le champ tel ne peut etre vide',
            ]
        );

        $users = User::latest();
        if ($users
            ->where('name', $request->name)
            ->where('prenom', $request->prenom)
            ->where('email', $request->email)
            ->where('tel', $request->tel)
            ->first()
        ) {
            $messages = ['Cet enregistrement existe déjà'];
            return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $users->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $user = User::create($request->all());
        return $this->sendApiResponse($user, 'User ajouté', 201);
    }

    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                //'name' => 'required',
                //'prenom' => 'required',
                //'email' => 'required',
                //'password' => 'required',
                //'tel' => 'required',
            ],
            $messages = [
                //'name.required' => 'Le champ name ne peut etre vide',
                //'prenom.required' => 'Le champ prenom ne peut etre vide',
                //'email.required' => 'Le champ email ne peut etre vide',
                //'password.required' => 'Le champ password ne peut etre vide',
                //'tel.required' => 'Le champ tel ne peut etre vide',
            ]
        );

        $users = User::latest();
        if ($users
            ->where('name', $request->name)
            ->where('prenom', $request->prenom)
            ->where('email', $request->email)
            ->where('tel', $request->tel)
            ->where('id', '!=', $id)->first()
        ) {
            $messages = ['Cet enregistrement existe déjà'];
            return $this->sendApiErrors($messages);
        }

        if ($validator->fails()) return $this->sendApiErrors($validator->errors()->all());

        $user = User::find($id);
        $user->update($request->all());
        return $this->sendApiResponse($user, 'User modifié', 201);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return $this->sendApiResponse($user, 'User supprimé');
    }

    public function destroy_group(Request $request)
    {
        $key = 0;
        $nb_supprimes = 0;
        $messages = [];
        foreach ($request->selected_lines as $selected) {
            $user = User::find($selected);
            if (isset($user)) {
                if ($user->est_valide == 1) {
                    $messages[$key] = [
                        'severity' => 'warn',
                        'value' => 'Impossible de supprimer ID0' . $selected
                    ];
                    $key++;
                } else {
                    $user->delete();
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

    public function update_password(Request $request, $id)
    {
        $data = User::find($id);

        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required',
                'new_password' => 'required|min:8',
                'password_confirmation' => 'required',
            ],
            $messages = [
                'current_password.required' => 'Le champ mot de passe actuel ne peut etre vide',
                'new_password.required' => 'Le champ nouveau mot de passe ne peut etre vide',
                'new_password.min' => 'Le mot de passe doit avoir 8 caracteres minimum',
                'password_confirmation.required' => 'Le champ confirmation du mot de passe ne peut etre vide'
            ]
        );

        if ($validator->fails()) {
            return $this->sendApiErrors($validator->errors()->all());
        }

        if (Auth::attempt(['email' => $data->email, 'password' => $request->current_password])) {
            if ($request->new_password === $request->password_confirmation) {
                $data->password = Hash::make($request->new_password);
                $data->update();

                return $this->sendApiResponse($data, 'Mot de passe à jour');
            } else return  $this->sendApiErrors(['errors' => 'Les mots de passe ne correspondent pas.']);
        } else return $this->sendApiErrors(['errors' => 'L\'ancien mot de passe est incorrect.']);

        return $this->sendApiResponse($data, 'Mot de passe à jour');
    }

    public function reset_password($id)
    {
        //On recupere l'utilisateur
        $data = User::find($id);

        if ($data->email !== null) {
            //On genere un mot de passe au hasard
            $new_pass = $data->id . Str::random(8);

            //on redige le mail
            $mail_content = [
                'libelle' => 'Vos identifiants de connexion Royal ASSURANCES',
                'destinataire' => $data->name,
                'description' => 'Voici ci dessous vos identifiants:
                Email: ' . $data->email . '
                Mot de passe: ' . $new_pass . '
                NB: Vous pouvez également utiliser votre numero de telephone à la place de votre email.'
            ];

            DB::table('users')->where('id', $id)->update(['password' =>  Hash::make($new_pass)]);

            // Mail::to($data->email)->queue(new StandartMail($mail_content));

            if (isset(auth('sanctum')->user()->id)) {
                $activite = [
                    'libelle' => 'réinitialisé un mot de passe',
                    'description' => 'Réinitialisation du mot de passe de l\'utilisateur ' . $data->name . ' par l\'utilisateur ' . auth('sanctum')->user()->name . ' le ' . now()->format('d/m/Y H:i'),
                    'ligne' => $data->id,
                    'table' => 'users',
                    'details' => $data,
                    'app_route' => '',
                ];
                $this->storeActivity($activite);
            }
        } else {
            $data->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
            $data->update();
        }

        return $this->sendApiResponse([], 'Mot de passe de ' . $data->name . ' réinitialisé');
    }
}
