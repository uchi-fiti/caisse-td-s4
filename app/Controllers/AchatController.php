<?php

namespace App\Controllers;

use App\Models\CaisseModel;

class AchatController extends BaseController
{
    public function index(): string
    {
        $data = $this->request->getPost();
        $caisseName = $data['nomCaisse'];
        $caisse = getCaisseByName($name);

        if($caisse){
            session()->set([
                'caisse_id' => $caisse['id'],
                'caisse_nom' => $caisse['nom']
            ]);
        }else{
            return redirect()->to('/caisse/choix');
        }
        
        return view('page');
    }
}
