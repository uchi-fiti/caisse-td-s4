Conception base :

table produit(
    id,
    designation,
    prix,
    qttStock
)
caisse(
    id,
    nom
)
achat(
    id,
    idProduit,
    idCaisse,
    dateAchat
)

- Controller pour rediriger vers la page d'input de numero de caisse
    - prendre liste des caisses
    - afficher dans le dropdown
      
- Controller pour rediriger vers une page de saisie des achats
    - function post : prendre le numero / nom puis faire getCaisseByname
    - rediriger vers la page avec data la caisse trouvee

- Attendre le template du binome