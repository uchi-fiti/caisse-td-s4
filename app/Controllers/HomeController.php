<?php

namespace App\Controllers;

use App\Models\CaisseModel;

class HomeController extends BaseController
{
    public function index(): string
    {
        $cm = new CaisseModel();
        $caisses = $cm->findAll();

        return view('page', [ 'caisses' => $caisses ]);
    }
}
