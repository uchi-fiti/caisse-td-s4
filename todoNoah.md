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