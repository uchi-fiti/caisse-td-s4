<?php

namespace App\Controllers;

use App\Models\CaisseModel;

class AchatController extends BaseController
{
    public function index(): string
    {
        $data = $this->request->getPost();
        $caisseName = $data['nomCaisse'];
        $caisse ;
        
        return view('page', [ 'caisse' => $caisse ]);
    }
}
