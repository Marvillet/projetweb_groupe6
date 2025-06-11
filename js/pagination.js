/** @fileoverview
 * Gère la pagination d'un tableau HTML en affichant un nombre limité de lignes par page.
 * Ajoute dynamiquement les contrôles de navigation (Précédent, Suivant, pages numérotées).
 */

const rowsPerPage = 10;  ///< Nombre de lignes affichées par page

/**
 * Affiche une page spécifique du tableau avec les lignes correspondantes.
 * Met à jour également la barre de pagination.
 *
 * @function
 * @global
 * @param {number} page - Le numéro de la page à afficher (commence à 1)
 */
window.displayPage = function(page) {
    const tbody = document.getElementById("resultat");
    const pagination = document.getElementById("pagination");

    if (!tbody || !pagination) return;

    const rows = Array.from(tbody.querySelectorAll("tr"));
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    // Correction pour éviter de dépasser les limites
    if (page < 1) page = 1;
    if (page > totalPages) page = totalPages;

    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    // Affiche les lignes de la page en cours et masque les autres
    rows.forEach((row, index) => {
        row.style.display = (index >= start && index < end) ? "" : "none";
    });

    // Réinitialise la pagination
    pagination.innerHTML = "";

    // Bouton "Précédent"
    const prevLi = document.createElement("li");
    prevLi.className = `page-item ${page === 1 ? "disabled" : ""}`;
    const prevBtn = document.createElement("button");
    prevBtn.className = "page-link";
    prevBtn.textContent = "Précédent";
    prevBtn.onclick = () => window.displayPage(page - 1);
    prevLi.appendChild(prevBtn);
    pagination.appendChild(prevLi);

    // Boutons de pages numérotées
    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement("li");
        li.className = `page-item ${i === page ? "active" : ""}`;
        const btn = document.createElement("button");
        btn.className = "page-link";
        btn.textContent = i;
        btn.onclick = () => window.displayPage(i);
        li.appendChild(btn);
        pagination.appendChild(li);
    }

    // Bouton "Suivant"
    const nextLi = document.createElement("li");
    nextLi.className = `page-item ${page === totalPages ? "disabled" : ""}`;
    const nextBtn = document.createElement("button");
    nextBtn.className = "page-link";
    nextBtn.textContent = "Suivant";
    nextBtn.onclick = () => window.displayPage(page + 1);
    nextLi.appendChild(nextBtn);
    pagination.appendChild(nextLi);
}
