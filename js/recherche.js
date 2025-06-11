/**
 * @fileoverview
 * Script principal de la page d'accueil.
 * - Initialise les champs de recherche avec Select2.
 * - Gère l'insertion des données dans le tableau.
 * - Lance la recherche automatique à l'ouverture.
 * - Affiche les erreurs de l'API.
 */

'use strict';

/**
 * Insère les données reçues de l'API dans un tableau HTML.
 *
 * @function
 * @param {Array<Object>} data - Liste des installations à afficher
 * @param {number} code - Code de statut HTTP de la réponse
 */
function tableau_insertion(data, code) {
    if (code === 200 || code === 201) {
        $('#errors').hide();
        let mois = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet",
            "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
        let tableau = document.getElementById("resultat");
        let text = "";

        data.forEach((value) => {
            text += "<tr>\n" +
                `<td>${mois[value["mois_installation"] - 1]} ${value["an_installation"]}</td>\n` +
                `<td>${value["nb_panneaux"]}</td>\n` +
                `<td>${value["surface"]}</td>\n` +
                `<td>${value["puissance_crete"]}</td>\n` +
                `<td>${value["lat"]}lat, ${value["lon"]}lon</td>\n` +
                `<td><a href="detail.html?id=${value["id"]}" class="btn btn-outline-primary btn-sm" title="Voir le détail"><i class="bi bi-search"></i></a></td>\n` +
                "</tr>";
        });

        tableau.innerHTML = text;

        if (typeof window.displayPage === 'function') {
            window.displayPage(1);
        } else {
            console.error("️ window.displayPage n’est pas défini !");
        }
    } else if (code === 444) {
        $('#errors').html('<i class="fa fa-exclamation-circle"></i> <strong>Aucune installation avec ces filtres</strong>');
        $('#errors').show();
        $('#panneau, #onduleur, #departement').val(null).trigger('change');
    } else {
        const messages = {
            400: 'Requête incorrecte',
            401: 'Authentifiez vous',
            403: 'Accès refusé',
            404: 'Page non trouvée',
            500: 'Erreur interne du serveur',
            503: 'Service indisponible'
        };

        if (code in messages) {
            $('#errors').html(`<i class="fa fa-exclamation-circle"></i> <strong>${messages[code]}</strong>`);
            $('#errors').show();
        }
    }
}

/**
 * Effectue une recherche d’installations selon les filtres sélectionnés
 * et met à jour le tableau de résultats.
 *
 * @function
 */
function recherche() {
    console.log("oui");
    const panneau = $('#panneau').val();
    const onduleur = $('#onduleur').val();
    const departement = $('#departement').val();
    console.log(panneau, onduleur, departement);

    const url = `../php/request.php/recherche?id_ond=${onduleur}&id_pan=${panneau}&id_dep=${departement}`;
    ajaxRequest2('GET', url, tableau_insertion);
}

/**
 * Initialise les composants et déclenche la recherche au chargement.
 *
 * @function
 * @event DOMContentLoaded
 */
window.addEventListener("DOMContentLoaded", () => {
    const currentPage = window.location.pathname.split("/").pop();

    // Active le lien de navigation correspondant à la page courante
    document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });

    // Lancement automatique d’une recherche au chargement
    recherche();

    // Rechercher à la soumission du formulaire
    document.getElementById("formulaire").addEventListener("submit", (event) => {
        event.preventDefault();
        recherche();
    });

    // Configuration des champs de recherche avec Select2
    $('#panneau').select2({
        placeholder: "Rechercher une marque...",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                const url = query === ''
                    ? '../php/request.php/panneau/marque'
                    : `../php/request.php/panneau/marque?marque=${encodeURIComponent(query)}`;

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

    $('#onduleur').select2({
        placeholder: "Rechercher une marque...",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                const url = query === ''
                    ? '../php/request.php/onduleur/marque'
                    : `../php/request.php/onduleur/marque?marque=${encodeURIComponent(query)}`;

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

    $('#departement').select2({
        placeholder: "Rechercher un departement ...",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                const url = query === ''
                    ? '../php/request.php/lieu/departement'
                    : `../php/request.php/lieu/departement?dep=${encodeURIComponent(query)}`;

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.dep_code,
                        text: item.dep_nom
                    }));
                    success({ results: formattedResults });
                });
            }
        }
    });
});
