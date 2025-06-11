'use strict';

/** @fileoverview
 * Script de la page de détails d'une installation photovoltaïque.
 * Récupère les données via l'API et les affiche dynamiquement dans deux colonnes.
 * Met à jour également une carte Google Maps.
 */

window.addEventListener("DOMContentLoaded", main);

/**
 * Fonction principale exécutée au chargement de la page.
 * Récupère l'ID depuis l'URL, puis appelle l'API pour obtenir les détails.
 * @function
 */
function main() {
    const id = getIdFromUrl();
    console.log(`Appel API pour l'installation ID=${id}`);
    ajaxRequest("GET", `../php/request.php/installation/${id}`, remplirDetails);
}

/**
 * Récupère l'ID de l'installation à partir de l'URL (paramètre `id`).
 * @function
 * @returns {string|null} L'identifiant de l'installation ou `null` si absent.
 */
function getIdFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get("id");
}

/**
 * Remplit dynamiquement les deux colonnes de détails à partir des données API.
 * Met également à jour la carte Google Maps intégrée.
 * @function
 * @param {Object[]} data - Données de l'installation photovoltaïque.
 */
function remplirDetails(data) {
    const mois = [
        "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
        "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
    ];

    if (!data) return;

    const list1 = document.querySelectorAll(".list-group")[0].children;
    const list2 = document.querySelectorAll(".list-group")[1].children;

    // Colonne 1 : données techniques
    list1[0].innerHTML = `<strong>Mois d'installation :</strong> ${mois[data[0]['mois_installation']-1]}`;
    list1[1].innerHTML = `<strong>Année d'installation :</strong> ${data[0]['an_installation']}`;
    list1[2].innerHTML = `<strong>Nombre de panneaux :</strong> ${data[0]['nb_panneaux']}`;
    list1[3].innerHTML = `<strong>Marque des panneaux :</strong> ${data[0]['panneau_marque']}`;
    list1[4].innerHTML = `<strong>Modèle des panneaux :</strong> ${data[0]['panneau_modele']}`;
    list1[5].innerHTML = `<strong>Marque onduleur :</strong> ${data[0]['onduleur_marque']}`;
    list1[6].innerHTML = `<strong>Modèle onduleur :</strong> ${data[0]['onduleur_modele']}`;
    list1[7].innerHTML = `<strong>Puissance crête :</strong> ${data[0]['puissance_crete']} kWc`;
    list1[8].innerHTML = `<strong>Surface :</strong> ${data[0]['surface']} m²`;
    list1[9].innerHTML = `<strong>Pente :</strong> ${data[0]['pente']}°`;
    list1[10].innerHTML = `<strong>Pente optimale :</strong> ${data[0]['pente_optimum']}°`;

    // Colonne 2 : informations géographiques et installateur
    list2[0].innerHTML = `<strong>Orientation :</strong> ${data[0]['orientation']}`;
    list2[1].innerHTML = `<strong>Orientation optimale :</strong> ${data[0]['orientation_optimum']}`;
    list2[2].innerHTML = `<strong>Installateur :</strong> ${data[0]['installateur']}`;
    list2[3].innerHTML = `<strong>Production PVGIS estimée :</strong> ${data[0]['puissance_pvgis']}`;
    list2[4].innerHTML = `<strong>Latitude :</strong> ${data[0]['lat']}`;
    list2[5].innerHTML = `<strong>Longitude :</strong> ${data[0]['lon']}`;
    list2[6].innerHTML = `<strong>Pays :</strong> ${data[0]['pays']}`;
    list2[7].innerHTML = `<strong>Code postal :</strong> ${data[0]['code_postal']}`;
    list2[8].innerHTML = `<strong>Ville :</strong> ${data[0]['commune']}`;
    list2[9].innerHTML = `<strong>Région :</strong> ${data[0]['region']}`;
    list2[10].innerHTML = `<strong>Département :</strong> ${data[0]['departement']}`;

    // Met à jour la carte intégrée
    updateMap(data[0]['lat'], data[0]['lon']);
}

/**
 * Met à jour la carte Google Maps en fonction des coordonnées passées.
 * @function
 * @param {string} lat - Latitude du lieu.
 * @param {string} lon - Longitude du lieu.
 */
function updateMap(lat, lon) {
    const iframe = document.querySelector("iframe");
    if (iframe && lat && lon) {
        iframe.src = `https://maps.google.com/maps?q=${lat},${lon}&z=15&output=embed`;
    }
}
