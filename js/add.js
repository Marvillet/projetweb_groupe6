/**
 * @file installation.js
 * @brief Script de gestion de l'ajout d'une installation photovoltaïque via un formulaire.
 */

'use strict'

/**
 * @brief Écouteur principal exécuté lorsque le DOM est complètement chargé.
 * Initialise le toast et les menus déroulants.
 */
window.addEventListener("DOMContentLoaded", main);

let toastEl;  /**< Élément HTML utilisé pour afficher les messages (toasts). */
let toast;    /**< Instance de bootstrap.Toast pour afficher les notifications. */

/**
 * @brief Fonction principale exécutée au chargement de la page.
 * Initialise le formulaire, les menus déroulants et les toasts.
 */
function main() {
    toastEl = document.getElementById("toast-msg");
    toast = new bootstrap.Toast(toastEl);

    definitionselect(); // initialise les select2
    let form = document.getElementById("installation-form");
    form.addEventListener("submit", addinstall);
}

/**
 * @brief Gère l'envoi du formulaire d'installation.
 * @param {Event} event L'événement de soumission du formulaire.
 */
function addinstall(event) {
    event.preventDefault();

    const formData = {
        mois_installation: document.getElementById('mois_installation').value,
        an_installation: document.getElementById('an_installation').value,
        nb_panneaux: document.getElementById('nb_panneaux').value,
        id_panneau_marque: $('#id_panneau_marque').val(),
        id_panneau_modele: $('#id_panneau_modele').val(),
        nb_onduleur: document.getElementById('nb_onduleur').value,
        id_onduleur_marque: $('#id_onduleur_marque').val(),
        id_onduleur_modele: $('#id_onduleur_modele').val(),
        puissance_crete: document.getElementById('puissance_crete').value,
        surface: document.getElementById('surface').value,
        orientation: document.getElementById('orientation').value,
        orientation_optimum: document.getElementById('orientation_opt').value,
        id_installateur: $('#id_installateur').val(),
        puissance_pvgis: document.getElementById('puissance_pvgis').value,
        lat: document.getElementById('lat').value,
        lon: document.getElementById('lon').value,
        code_insee: $('#code_insee').val(),
        pente: document.getElementById('pente').value,
        pente_optimum: document.getElementById('pente_optimum').value
    };

    console.log(encodeFormData(formData));
    ajaxRequest2('POST', "../php/request.php/admin", affichetoast, encodeFormData(formData));
}

/**
 * @brief Affiche une notification après la tentative d'ajout des données.
 * @param {string} message Message retourné (non utilisé).
 * @param {number} status Code HTTP de la réponse (200/201 = succès, sinon erreur).
 */
function affichetoast(message, status) {
    toastEl.classList.remove("bg-success", "bg-danger");

    if (status === 201 || status === 200) {
        toastEl.classList.add("bg-success");
        toastEl.querySelector(".toast-body").textContent = "Ajout des datas réussies";
    } else {
        toastEl.classList.add("bg-danger");
        toastEl.querySelector(".toast-body").textContent = "Erreur ajout";
    }

    toast.show();
}

/**
 * @brief Initialise les éléments de formulaire utilisant Select2 avec données dynamiques.
 * Configure les champs : installateur, commune, panneau (marque/modèle), onduleur (marque/modèle).
 */
function definitionselect() {
    // ========== Installateur ==========
    $('#id_installateur').select2({
        width: '100%',
        placeholder: "Rechercher un installateur",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = query === '' ? '../php/request.php/installateur' : `../php/request.php/installateur?filtre=${encodeURIComponent(query)}`;

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_installateur,
                        text: item.installateurs
                    }));
                    success({ results: formattedResults });
                });
            }
        }
    });

    // ========== Commune ==========
    $('#code_insee').select2({
        width: '100%',
        placeholder: "Rechercher une commune",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = query === '' ? '../php/request.php/lieu/commune' : `../php/request.php/lieu/commune?commune=${encodeURIComponent(query)}`;

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.code_insee,
                        text: `${item.nom_standard} (${item.code_postal})`
                    }));
                    success({ results: formattedResults });
                });
            }
        }
    });

    // ========== Panneau - Marque ==========
    $('#id_panneau_marque').select2({
        width: '100%',
        placeholder: "Rechercher une marque de panneau",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = query === '' ? '../php/request.php/panneau/marque' : `../php/request.php/panneau/marque?marque=${encodeURIComponent(query)}`;

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_panneau_marque,
                        text: item.panneau_marque
                    }));
                    success({ results: formattedResults });
                });
            }
        }
    });

    // ========== Panneau - Modèle ==========
    $('#id_panneau_modele').select2({
        width: '100%',
        placeholder: "Rechercher un modèle de panneau",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = query === '' ? '../php/request.php/panneau/modele' : `../php/request.php/panneau/modele?modele=${encodeURIComponent(query)}`;

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_panneau_modele,
                        text: item.panneau_modele
                    }));
                    success({ results: formattedResults });
                });
            }
        }
    });

    // ========== Onduleur - Marque ==========
    $('#id_onduleur_marque').select2({
        width: '100%',
        placeholder: "Rechercher une marque d'onduleur",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = query === '' ? '../php/request.php/onduleur/marque' : `../php/request.php/onduleur/marque?marque=${encodeURIComponent(query)}`;

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_onduleur_marque,
                        text: item.onduleur_marque
                    }));
                    success({ results: formattedResults });
                });
            }
        }
    });

    // ========== Onduleur - Modèle ==========
    $('#id_onduleur_modele').select2({
        width: '100%',
        placeholder: "Rechercher un modèle d'onduleur",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = query === '' ? '../php/request.php/onduleur/modele' : `../php/request.php/onduleur/modele?modele=${encodeURIComponent(query)}`;

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_onduleur_modele,
                        text: item.onduleur_modele
                    }));
                    success({ results: formattedResults });
                });
            }
        }
    });
}
