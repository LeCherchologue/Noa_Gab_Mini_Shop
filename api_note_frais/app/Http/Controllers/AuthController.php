<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function index()
    {
        return $this->sendApiResponse([], 'Connexion au serveur réussi !');
    }

    //fonction pour le login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials) || (Auth::attempt(['telephone1' => $request->email, 'password' => $request->password])) || (Auth::attempt(['telephone2' => $request->email, 'password' => $request->password]))) {

            $user = Auth::user();


            $user_datas = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "telephone" => $user->tel,
                "prenom" => $user->prenom,
                "statut" => $user->statut,
                "token" => $user->createToken("royal_token_" . Str::slug($user->name . ' ' . now(), '_'))->plainTextToken,

            ];

            return $this->sendApiResponse($user_datas, 'Vous etes connecté');
        }

        return $this->sendApiErrors(['Indentifiants incorrects.']);
    }

    public function logout()
    {
        if (!isset(auth('sanctum')->user()->id)) {
            $user = User::find(auth('sanctum')->user()->id);

            if ($user->tokens()->delete()) {
                return $this->sendApiResponse([], 'Vous etes déconnecté');
            } else $this->sendApiErrors(['Erreur réseau, veuillez reessayer.']);
        }

        return $this->sendApiResponse([], 'Vous etes déconnecté');
    }
}
