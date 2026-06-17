<?php

namespace App\Controllers;

use App\Models\CaisseModel;
use App\Models\ProduitModel;

class AchatController extends BaseController
{
public function index()
    {
        $data = $this->request->getPost();
        $name = $data['nomCaisse'];

        $cm = new CaisseModel();

        $caisse = $cm->getCaisseByName($name);

        if($caisse){
            session()->set([
                'caisse_id' => $caisse['id'],
                'caisse_nom' => $caisse['nom'],
                'caisse_is_active' => true
            ]);
        }else{
            return redirect()->to('/caisse/choix');
        }
        
        return redirect()->to('/saisie');
    }
    public function saisie() {
        return view('saisie');
    }
        public function addToCart(int $produitId, int $quantity)
    {
        if ($quantity < 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Quantité invalide.'
            ]);
        }
 
        $pm = new ProduitModel();
        $produit = $pm->find($produitId);
 
        if (!$produit) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produit introuvable.'
            ]);
        }
 
        $cart = session()->get('cart') ?? [];
        $cart[$produitId] = ($cart[$produitId] ?? 0) + $quantity;
 
        // Vérification simple du stock disponible
        // if ($cart[$produitId] > $produit['qttStock']) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'message' => 'Stock insuffisant pour ce produit.'
        //     ]);
        // }
 
        session()->set('cart', $cart);
 
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Produit ajouté au panier.',
            'cart' => $this->buildCartDetails($cart, $pm)
        ]);
    }
 
    private function buildCartDetails(array $cart, ProduitModel $pm): array
    {
        $items = [];
        $total = 0;
 
        foreach ($cart as $produitId => $quantite) {
            $produit = $pm->find($produitId);
 
            // Si le produit a été supprimé depuis, on ignore la ligne
            if (!$produit) {
                continue;
            }
 
            $sousTotal = $produit['prix'] * $quantite;
            $total += $sousTotal;
 
            $items[] = [
                'id'          => $produitId,
                'designation' => $produit['designation'],
                'prix'        => $produit['prix'],
                'quantite'    => $quantite,
                'sousTotal'   => $sousTotal,
            ];
        }
 
        return [
            'items' => $items,
            'total' => $total,
        ];
    }


}
