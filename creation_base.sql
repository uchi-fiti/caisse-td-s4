-- ============================================
-- Script SQLite3 : création de la base et insertion de données
-- ============================================

-- Activer les clés étrangères (désactivées par défaut dans SQLite)
PRAGMA foreign_keys = ON;

-- ============================================
-- Suppression des tables si elles existent déjà
-- ============================================
DROP TABLE IF EXISTS achat;
DROP TABLE IF EXISTS produit;
DROP TABLE IF EXISTS caisse;

-- ============================================
-- Création des tables
-- ============================================

CREATE TABLE produit (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    designation TEXT NOT NULL,
    prix        REAL NOT NULL,
    qttStock    INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE caisse (
    id   INTEGER PRIMARY KEY AUTOINCREMENT,
    nom  TEXT NOT NULL
);

CREATE TABLE achat (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    idProduit  INTEGER NOT NULL,
    idCaisse   INTEGER NOT NULL,
    dateAchat  TEXT NOT NULL,
    qtt INTEGER NOT NULL DEFAULT 1,
    FOREIGN KEY (idProduit) REFERENCES produit(id),
    FOREIGN KEY (idCaisse)  REFERENCES caisse(id)
);

-- ============================================
-- Insertion de 5 produits
-- ============================================

INSERT INTO produit (designation, prix, qttStock) VALUES
('Riz 1kg',            2500.00, 100),
('Huile végétale 1L',  6500.00,  50),
('Sucre 1kg',          3000.00,  80),
('Savon de toilette',  1200.00, 200),
('Farine de blé 1kg',  2800.00,  60);

-- ============================================
-- Insertion de 2 caisses
-- ============================================

INSERT INTO caisse (nom) VALUES
('Caisse 1'),
('Caisse 2');

-- ============================================
-- (Optionnel) Quelques exemples d'achats
-- ============================================

INSERT INTO achat (idProduit, idCaisse, dateAchat) VALUES
(1, 1, '2026-06-17'),
(3, 2, '2026-06-17');

-- ============================================
-- Vérification rapide
-- ============================================
-- SELECT * FROM produit;
-- SELECT * FROM caisse;
-- SELECT * FROM achat;
