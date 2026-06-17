/* ==========================================================================
   FraisMarché — logique front (données codées en dur, pas de backend)
   ========================================================================== */

// ---- données codées en dur -------------------------------------------------
const CAISSES = ["Caisse n°1", "Caisse n°2", "Caisse n°3", "Caisse n°4"];

const UTILISATEUR_ACTUEL = { nom: "Marie Dupont", role: "Caissière" };

const PRODUITS = [
  { id: "p1", nom: "Pommes (1 kg)", prix: 2.50 },
  { id: "p2", nom: "Bananes (1 kg)", prix: 1.90 },
  { id: "p3", nom: "Pain de mie", prix: 1.80 },
  { id: "p4", nom: "Lait demi-écrémé (1 L)", prix: 1.05 },
  { id: "p5", nom: "Yaourts nature (pack de 4)", prix: 2.20 },
  { id: "p6", nom: "Riz basmati (1 kg)", prix: 3.40 },
  { id: "p7", nom: "Pâtes (500 g)", prix: 1.15 },
  { id: "p8", nom: "Café moulu (250 g)", prix: 4.50 },
  { id: "p9", nom: "Œufs (boîte de 6)", prix: 2.80 },
  { id: "p10", nom: "Eau minérale (1,5 L)", prix: 0.65 },
];

function formatEUR(valeur) {
  return valeur.toFixed(2).replace(".", ",") + " €";
}

// ---- remplissage du sidebar (utilisateur + caisse active) -----------------
function initSidebarCommun() {
  const nomEl = document.querySelector("[data-user-name]");
  const roleEl = document.querySelector("[data-user-role]");
  if (nomEl) nomEl.textContent = UTILISATEUR_ACTUEL.nom;
  if (roleEl) roleEl.textContent = UTILISATEUR_ACTUEL.role;

  const caisseBadge = document.querySelector("[data-caisse-badge]");
  if (caisseBadge) {
    const caisseActive = localStorage.getItem("fm_caisse");
    if (caisseActive) {
      caisseBadge.classList.remove("is-empty");
      caisseBadge.innerHTML = `<i class="bi bi-cash-stack"></i> ${caisseActive}`;
    } else {
      caisseBadge.classList.add("is-empty");
      caisseBadge.innerHTML = `<i class="bi bi-dash-circle"></i> Aucune caisse`;
    }
  }

  document.querySelectorAll(".logout-link").forEach((lien) => {
    lien.addEventListener("click", () => {
      localStorage.removeItem("fm_caisse");
    });
  });
}

// ---- page login -------------------------------------------------------------
function initPageLogin() {
  const form = document.getElementById("loginForm");
  if (!form) return;

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    e.stopPropagation();

    if (!form.checkValidity()) {
      form.classList.add("was-validated");
      return;
    }

    // Authentification simulée (pas de backend dans ce template)
    window.location.href = "accueil.html";
  });
}

// ---- page d'accueil (sélection de caisse) -----------------------------------
function initPageAccueil() {
  const select = document.getElementById("caisseSelect");
  const form = document.getElementById("accueilForm");
  if (!form || !select) return;

  CAISSES.forEach((caisse) => {
    const option = document.createElement("option");
    option.value = caisse;
    option.textContent = caisse;
    select.appendChild(option);
  });

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    e.stopPropagation();

    if (!select.value) {
      form.classList.add("was-validated");
      return;
    }

    localStorage.setItem("fm_caisse", select.value);
    window.location.href = "saisie.html";
  });
}

// ---- page de saisie des achats ----------------------------------------------
function initPageSaisie() {
  const tbody = document.getElementById("achatsBody");
  if (!tbody) return;

  const produitSelect = document.getElementById("produitSelect");
  const quantiteInput = document.getElementById("quantiteInput");
  const ajoutForm = document.getElementById("ajoutForm");
  const totalAmount = document.getElementById("totalAmount");
  const emptyState = document.getElementById("receiptEmpty");
  const btnCloturer = document.getElementById("btnCloturer");
  const modalRecapBody = document.getElementById("modalRecapBody");
  const modalRecapTotal = document.getElementById("modalRecapTotal");
  const btnConfirmerCloture = document.getElementById("btnConfirmerCloture");

  let panier = [];

  // remplir le dropdown produits
  PRODUITS.forEach((produit) => {
    const option = document.createElement("option");
    option.value = produit.id;
    option.textContent = `${produit.nom} — ${formatEUR(produit.prix)}`;
    produitSelect.appendChild(option);
  });

  function recalculerTotal() {
    const total = panier.reduce((acc, ligne) => acc + ligne.sousTotal, 0);
    totalAmount.textContent = formatEUR(total);
    btnCloturer.disabled = panier.length === 0;
    emptyState.classList.toggle("d-none", panier.length > 0);
    document.getElementById("achatsTable").classList.toggle("d-none", panier.length === 0);
  }

  function dessinerLignes() {
    tbody.innerHTML = "";
    panier.forEach((ligne, index) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${ligne.nom}</td>
        <td class="qty-cell">${formatEUR(ligne.prix)}</td>
        <td class="qty-cell text-center">${ligne.quantite}</td>
        <td class="qty-cell fw-semibold">${formatEUR(ligne.sousTotal)}</td>
        <td class="text-end">
          <button type="button" class="btn btn-sm btn-link btn-danger-link" data-supprimer="${index}" aria-label="Supprimer cette ligne">
            <i class="bi bi-trash3"></i>
          </button>
        </td>`;
      tbody.appendChild(tr);
    });
  }

  ajoutForm.addEventListener("submit", (e) => {
    e.preventDefault();
    e.stopPropagation();

    const produit = PRODUITS.find((p) => p.id === produitSelect.value);
    const quantite = parseInt(quantiteInput.value, 10);

    if (!produit || !quantite || quantite < 1) {
      ajoutForm.classList.add("was-validated");
      return;
    }

    panier.push({
      nom: produit.nom,
      prix: produit.prix,
      quantite: quantite,
      sousTotal: produit.prix * quantite,
    });

    dessinerLignes();
    recalculerTotal();

    ajoutForm.classList.remove("was-validated");
    ajoutForm.reset();
    produitSelect.focus();
  });

  tbody.addEventListener("click", (e) => {
    const btn = e.target.closest("[data-supprimer]");
    if (!btn) return;
    const index = parseInt(btn.getAttribute("data-supprimer"), 10);
    panier.splice(index, 1);
    dessinerLignes();
    recalculerTotal();
  });

  btnCloturer.addEventListener("click", () => {
    if (panier.length === 0) return;

    modalRecapBody.innerHTML = panier
      .map(
        (ligne) => `
        <div class="d-flex justify-content-between small mb-1">
          <span>${ligne.quantite} × ${ligne.nom}</span>
          <span class="qty-cell">${formatEUR(ligne.sousTotal)}</span>
        </div>`
      )
      .join("");

    const total = panier.reduce((acc, ligne) => acc + ligne.sousTotal, 0);
    modalRecapTotal.textContent = formatEUR(total);

    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById("clotureModal"));
    modal.show();
  });

  btnConfirmerCloture.addEventListener("click", () => {
    panier = [];
    dessinerLignes();
    recalculerTotal();

    const modal = bootstrap.Modal.getInstance(document.getElementById("clotureModal"));
    modal.hide();

    const toast = bootstrap.Toast.getOrCreateInstance(document.getElementById("successToast"));
    toast.show();
  });

  recalculerTotal();
}

document.addEventListener("DOMContentLoaded", () => {
  initSidebarCommun();
  initPageLogin();
  initPageAccueil();
  initPageSaisie();
});
