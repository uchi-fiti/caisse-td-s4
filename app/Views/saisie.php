<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Saisie des achats — FraisMarché Caisse</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="/style.css" rel="stylesheet">
</head>
<body>

  <!-- Barre mobile (visible < lg) -->
  <nav class="navbar mobile-topbar d-lg-none">
    <div class="container-fluid">
      <button class="btn-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#appSidebar" aria-controls="appSidebar" aria-label="Ouvrir le menu">
        <i class="bi bi-list"></i>
      </button>
      <span class="navbar-brand mb-0">FraisMarché</span>
      <span style="width:1.4rem;"></span>
    </div>
  </nav>

  <div class="app-layout">

    <!-- ===================== SIDEBAR (commun accueil + saisie) ===================== -->
    <div class="offcanvas-lg offcanvas-start app-sidebar d-flex flex-column" tabindex="-1" id="appSidebar">

      <div class="offcanvas-header d-lg-none">
        <span class="brand-name display-font">FraisMarché</span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#appSidebar" aria-label="Fermer"></button>
      </div>

      <div class="offcanvas-body d-flex flex-column p-0">

        <div class="sidebar-brand d-none d-lg-flex">
          <span class="brand-icon"><i class="bi bi-bag-check-fill"></i></span>
          <span class="brand-name">FraisMarché</span>
        </div>

        <div class="sidebar-user d-flex align-items-center gap-2">
          <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
          <div>
<div class="user-name" data-user-name><?= session()->get('isLoggedIn') ? session()->get('user_nom') : '—'?></div>
            <div class="user-role" data-user-role><?= session()->get('isLoggedIn') ? session()->get('identifiant') : '—'?></div>
          </div>
        </div>

        <div class="sidebar-caisse">
          <span class="caisse-label">Caisse active</span>
          <span class="caisse-badge is-empty" data-caisse-badge><?php echo esc(session()->get('caisse_nom'))?></span>

        </div>

        <nav class="sidebar-nav nav flex-column">
          <a href="<?= site_url('caisse/choix') ?>" class="nav-link"><i class="bi bi-house-door-fill"></i> Accueil</a>
          <a href="#" class="nav-link active"><i class="bi bi-cart-plus-fill"></i> Saisie des achats</a>
        </nav>

        <div class="sidebar-footer">
          <a href="login.html" class="logout-link"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </div>

      </div>
    </div>
    <!-- ===================== /SIDEBAR ===================== -->

    <main class="app-main">

      <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
          <h1 class="h4 mb-1">Saisie des achats</h1>
          <p class="text-muted-ink mb-0">Ajoutez les produits scannés ou sélectionnés pour le client en cours.</p>
        </div>
      </div>

      <!-- Formulaire d'ajout -->
      <div class="card mb-4">
        <div class="card-body p-4">
          <form id="ajoutForm" class="row g-3 align-items-end needs-validation" novalidate>

            <div class="col-12 col-md-6">
              <label for="produitSelect" class="form-label">Produit</label>
              <select class="form-select" id="produitSelect" required>
                <option value="" selected disabled>Choisir un produit…</option>
                <!-- options ajoutées dynamiquement depuis la liste codée en dur -->
              </select>
              <div class="invalid-feedback">Merci de sélectionner un produit.</div>
            </div>

            <div class="col-7 col-md-3">
              <label for="quantiteInput" class="form-label">Quantité</label>
              <input type="number" class="form-control" id="quantiteInput" min="1" step="1" value="1" required>
              <div class="invalid-feedback">Quantité invalide.</div>
            </div>

            <div class="col-5 col-md-3">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-plus-circle me-1"></i> Valider
              </button>
            </div>

          </form>
        </div>
      </div>

      <!-- Ticket / tableau des achats saisis -->
      <div class="receipt-card mb-4">

        <div id="receiptEmpty" class="receipt-empty">
          <i class="bi bi-receipt fs-2 d-block mb-2"></i>
          Aucun produit saisi pour le moment.
        </div>

        <div class="table-responsive">
          <table id="achatsTable" class="table receipt-table d-none">
            <thead>
              <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th class="text-center">Quantité</th>
                <th>Total</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>
            <tbody id="achatsBody">
              <!-- lignes ajoutées dynamiquement -->
            </tbody>
          </table>
        </div>

        <div class="receipt-total">
          <span><i class="bi bi-calculator me-2"></i>Total</span>
          <span class="amount" id="totalAmount">0,00 €</span>
        </div>
      </div>

      <div class="text-end">
        <button type="button" id="btnCloturer" class="btn btn-success py-2 px-4" disabled>
          <i class="bi bi-bag-check me-1"></i> Clôturer les achats
        </button>
      </div>

    </main>

  </div>

  <!-- Modale récapitulative de clôture -->
  <div class="modal fade" id="clotureModal" tabindex="-1" aria-labelledby="clotureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title h5" id="clotureModalLabel"><i class="bi bi-receipt me-2"></i>Récapitulatif du client</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <div id="modalRecapBody" class="mb-3"></div>
          <hr>
          <div class="d-flex justify-content-between fw-semibold">
            <span>Total à encaisser</span>
            <span class="qty-cell" id="modalRecapTotal">0,00 €</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-success" id="btnConfirmerCloture">
            <i class="bi bi-check-circle me-1"></i> Confirmer la clôture
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast de confirmation -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="successToast" class="toast text-bg-light" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <i class="bi bi-check-circle-fill text-success me-2"></i>
        <strong class="me-auto">Achats clôturés</strong>
      </div>
      <div class="toast-body">
        La vente a été enregistrée. Prêt pour le client suivant.
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/app.js"></script>
</body>
</html>
