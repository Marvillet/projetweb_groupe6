/**
 * @file main.js
 * @brief Script principal de gestion des installations photovoltaïques.
 * Active le lien du menu correspondant à la page actuelle, initialise les événements,
 * gère l'ouverture de la modale, l'ajout via formulaire, l'affichage de notifications, etc.
 */

window.addEventListener("DOMContentLoaded", main);

let toast;

/**
 * @function main
 * @brief Fonction principale exécutée au chargement du DOM.
 */
function main() {
    const currentPage = window.location.pathname.split("/").pop();

    // Active le lien correspondant à la page actuelle
    document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });

    const urlrecherche = "../php/request.php/admin";
    const tbody = document.getElementById("installations-body");
    const modalEl = document.getElementById("installationModal");
    const form = document.getElementById("installation-form");
    const toastEl = document.getElementById("toast-msg");

    const modal = new bootstrap.Modal(modalEl);
    toast = new bootstrap.Toast(toastEl);

    // Change le titre de la modale selon le choix
    document.getElementById("choix").addEventListener("change", (event) => {
        modalEl.querySelector(".modal-title").textContent = "Ajouter " + event.target.selected;
    });

    // Affiche la modale d'ajout
    document.getElementById("btn-add").addEventListener("click", () => {
        form.reset();
        modalEl.querySelector(".modal-title").textContent = "Ajouter une instance";
        modal.show();
    });

    // Gestion de la soumission du formulaire
    form.addEventListener("submit", (event) => {
        event.preventDefault();
        let choix = document.getElementById("choix");
        let denomination = document.getElementById("denomination").value;
        let url2 = "";
        let msg = "";
        let data = "";

        // Détermine l'URL et les données en fonction du choix
        switch (parseInt(choix.value)) {
            case 1:
                msg = "Installateur";
                url2 = "../php/request.php/installateur";
                data = "installateur";
                break;
            case 2:
                msg = "Modele de Panneau";
                url2 = "../php/request.php/panneau/modele";
                data = "modele";
                break;
            case 3:
                msg = "Marque de Panneau";
                url2 = "../php/request.php/panneau/marque";
                data = "marque";
                break;
            case 4:
                msg = "Modele de Onduleur";
                url2 = "../php/request.php/onduleur/modele";
                data = "modele";
                break;
            case 5:
                msg = "Modele de Onduleur";
                url2 = "../php/request.php/onduleur/marque";
                data = "marque";
                break;
        }

        // Envoie de la requête POST
        ajaxRequest2("POST", url2, (json, code) => {
            add(json, code, msg, toastEl);
        }, data + "=" + denomination);
    });

    // Récupère et affiche les installations
    ajaxRequest('GET', urlrecherche, addlignes);
}

/**
 * @function add
 * @brief Gère la réponse après soumission du formulaire d'ajout.
 * @param json Données retournées
 * @param code Code HTTP
 * @param msg Message d'opération
 * @param toastEl Élément HTML de toast
 */
function add(json, code, msg, toastEl) {
    if (code === 200 || code === 201) {
        affichetoast(toastEl, msg + " reussie");
        ajaxRequest('GET', "../php/request.php/admin", addlignes);
    } else {
        affichetoast(toastEl, "Echec de l'ajoue de " + msg, true);
    }
    const modal = bootstrap.Modal.getInstance(document.getElementById("installationModal"));
    modal.hide();
}

/**
 * @function addlignes
 * @brief Ajoute les lignes dans le tableau HTML à partir des données reçues.
 * @param rows Données des installations à afficher
 */
function addlignes(rows) {
    let tbody = document.getElementById("resultat");
    tbody.innerHTML = "";

    rows.forEach((row) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
              <td>${row['id']}</td>
              <td>${row['nb_panneaux']}</td>
              <td>${row['puissance_crete']}</td>
              <td>${row['nom_standard']}</td>
              <td>${row['mois_installation']} / ${row['an_installation']}</td>
              <td class="text-center">
                <a href="modif.php?id=${row['id']}" class="btn btn-sm btn-outline-primary me-2" title='Modification' ><i class="bi bi-pencil"></i></a>
                <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${row['id']}"><i class="bi bi-trash"></i></button>
                <a href="../front/detail.html?id=${row['id']}" class='btn btn-outline-primary btn-sm' title='Voir le détail'><i class="bi bi-search"></i></a>
              </td>
            `;
        tr.getElementsByClassName('btn-outline-primary')[0].addEventListener("click", installupdate);
        tr.getElementsByClassName('btn-outline-danger')[0].addEventListener("click", installdelete);
        tbody.appendChild(tr);
    });

    window.displayPage(1);
}

/**
 * @function affichetoast
 * @brief Affiche une notification en bas de page.
 * @param toastEl Élément HTML du toast
 * @param message Message à afficher
 * @param error Indique s'il s'agit d'une erreur
 */
function affichetoast(toastEl, message, error = false) {
    toastEl.classList.remove("bg-success", "bg-danger");
    toastEl.classList.add(error ? "bg-danger" : "bg-success");
    toastEl.querySelector(".toast-body").textContent = message;
    toast.show();
}

/**
 * @function installupdate
 * @brief Fonction placeholder pour la mise à jour d'une installation.
 * @param event Objet événement déclencheur
 */
function installupdate(event) {
    console.log(event.target.dataset.id);
    console.log("update");
    // À implémenter : mise à jour de l'installation
}

/**
 * @function installdelete
 * @brief Supprime une installation via requête AJAX.
 * @param event Objet événement déclencheur
 */
function installdelete(event) {
    console.log("delete");

    const button = event.target.closest('button');
    if (!button) return;

    const id = button.dataset.id;
    console.log("ID supprimé :", id);

    ajaxRequest('DELETE', '../php/request.php/admin/' + id, addlignes);
}
