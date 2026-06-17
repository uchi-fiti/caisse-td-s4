<?php

namespace App\Controllers;

use App\Models\CaisseModel;
use App\Models\ProduitModel;
use App\Models\AchatModel;

class SaisieController extends BaseController
{
    public function index(): string
    {
        $pm = new ProduitModel();
        $produits = $pm->findAll();

        return view('saisie', [ 'produits' => $produits , 'achats' => []]);
    }

    public function confirmer()
    {
        $cart = session()->get('cart') ?? [];
        $pm = new ProduitModel();
 
        foreach ($cart as $produitId => $quantite) {
            $produit = $pm->find($produitId);
 
            if (!$produit) {
                continue;
            }
 
            $achat = new AchatModel();
 
                $achat->save([
                    'idProduit' => $produitId,
                    'idCaisse'  => session()->get('caisse_id'),
                    'dateAchat' => date('Y-m-d H:i:s'),
                    'qtt' => $quantite
                ]);
            
        }
 
        // La vente est encaissée : on vide le panier pour le client suivant
        session()->remove('cart');
 
        return view('saisie', [
            'produits' => $pm->findAll(),
        ]);
    }


}
