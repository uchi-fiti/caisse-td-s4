<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index() {
        return view('auth/index');
    }
    public function login() {
        // Validation basique des champs reçus
        $rules = [
            'identifiant' => 'required',
            'mdp'         => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->to('auth/index')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $identifiant = $this->request->getPost('identifiant');
        $motDePasse  = $this->request->getPost('mdp');

        // 1. On cherche l'utilisateur par son identifiant
        $userModel = new UserModel();
        $user = $userModel->where('identifiant', $identifiant)->first();

        if ($user === null) {
            // On reste volontairement vague pour ne pas indiquer
            // si c'est l'identifiant ou le mot de passe qui est faux
            return redirect()
                ->to('auth/index')
                ->withInput()
                ->with('error', 'Identifiant ou mot de passe incorrect.');
        }

        // 2. On vérifie le mot de passe par rapport au hash stocké
        if (!password_verify($motDePasse, $user['mdpHashe'])) {
            return redirect()
            ->to('auth/index')
                ->withInput()
                ->with('error', 'Identifiant ou mot de passe incorrect.');
        }

        // Sécurité : on régénère l'ID de session pour éviter
        // une attaque par fixation de session
        session()->regenerate();

        // 3. On enregistre l'utilisateur en session
        session()->set([
            'user_id'     => $user['id'],
            'user_nom'    => $user['nom'],
            'identifiant' => $user['identifiant'],
            'isLoggedIn'  => true,
        ]);

        return redirect()->to('/caisse/choix');
    }
}
