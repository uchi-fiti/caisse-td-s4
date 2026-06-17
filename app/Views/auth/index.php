<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion — FraisMarché Caisse</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&family=Roboto+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="<?= base_url('style.css') ?>" rel="stylesheet">
</head>
<body>

  <div class="login-shell">

    <!-- Panneau de marque -->
    <aside class="login-aside">
      <div class="brand-icon-lg"><i class="bi bi-bag-check-fill"></i></div>
      <h1 class="display-font">FraisMarché Caisse</h1>
      <p>Espace réservé aux équipes en caisse pour enregistrer les achats et suivre les ventes du magasin.</p>
    </aside>

    <!-- Formulaire -->
    <div class="login-form-wrap">
      <div class="login-form-card">

        <div class="text-center mb-4">
          <div class="select-caisse-icon mx-auto mb-3">
            <i class="bi bi-person-circle"></i>
          </div>
          <h2 class="h4 mb-1">Connexion</h2>
          <p class="text-muted-ink mb-0">Connectez-vous pour accéder à votre poste de caisse</p>
        </div>

        <form method="post" action="<?= site_url('auth/login') ?>" id="loginForm" class="needs-validation" novalidate>

          <div class="mb-3">
            <label for="identifiant" class="form-label">Identifiant</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" id="identifiant" placeholder="ex. mdupont" name="identifiant" required>
              <div class="invalid-feedback">Merci de renseigner votre identifiant.</div>
            </div>
          </div>

          <div class="mb-3">
            <label for="motDePasse" class="form-label">Mot de passe</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" class="form-control" id="motDePasse" placeholder="••••••••" name="mdp" required>
              <div class="invalid-feedback">Merci de renseigner votre mot de passe.</div>
            </div>
          </div>

          <!-- <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="seSouvenir">
              <label class="form-check-label small" for="seSouvenir">Se souvenir de moi</label>
            </div>
            <a href="#" class="small">Mot de passe oublié ?</a>
          </div> -->

          <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
          </button>

        </form>

      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/app.js"></script>
</body>
</html>
