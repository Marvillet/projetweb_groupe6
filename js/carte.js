'use strict';

/** @fileoverview Script de gestion de carte Leaflet, affichage dynamique d'informations
 * photovoltaïques et interaction avec des filtres AJAX.
 */

/** @var {L.Map} map - Carte Leaflet principale */
let map;

/** @var {L.LayerGroup} markersLayer - Groupe de couches pour contenir les marqueurs dynamiques */
let markersLayer;

/**
 * Affiche les détails d'une installation photovoltaïque.
 * @function
 * @param {string} villeId - ID de la ville sélectionnée.
 */
function showInfo(villeId) {
    const info = document.getElementById('info');
    info.style.display = 'block';

    console.log("ID de la ville sélectionnée :", villeId);

    // Appelle une requête AJAX pour charger les détails
    ajaxRequest('GET', `../php/request.php/installation/${villeId}`, remplirDetailsVille);
}

/**
 * Masque la boîte d'information sur l'installation.
 * @function
 */
function hideInfo() {
    const info = document.getElementById('info');
    info.style.display = 'none';
}

/**
 * Initialise la carte Leaflet et le fond de carte OpenStreetMap.
 * @function
 */
function initMap() {
    map = L.map('map').setView([46.603354, 1.888334], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    markersLayer = L.layerGroup().addTo(map);
}

/**
 * Ajoute des marqueurs de coordonnées à la carte.
 * @function
 * @param {Object[]} data - Liste des objets contenant les coordonnées et identifiants.
 */
function ajoutCoord(data) {
    const messageDiv = document.getElementById('message');
    markersLayer.clearLayers();

    if (data.length === 0) {
        messageDiv.classList.remove('d-none');
        messageDiv.classList.add('d-block');
        return;
    } else {
        messageDiv.classList.add('d-none');
        messageDiv.classList.remove('d-block');
    }

    data.forEach(dt => {
        console.log(dt.id)
        if (dt.lat && dt.lon) {
            const marker = L.marker([dt.lat, dt.lon])
                .bindPopup('<b>Installation photovoltaïque</b><br><button class="showInfo" onclick="showInfo(\''+dt.id+'\')">Voir détail</button>');
            markersLayer.addLayer(marker);
        }
    });

    const bounds = L.latLngBounds(data.map(d => [d.lat, d.lon]));
    map.fitBounds(bounds, { padding: [50, 50] });
}

/**
 * Remplit dynamiquement le select des années.
 * @function
 * @param {Object[]} annees - Liste d'années à insérer dans le select.
 */
function recupAnnee(annees) {
    const an = document.getElementById('annee');
    an.innerHTML = '<option value="">-- Sélectionner --</option>';
    annees.forEach(annee => {
        an.innerHTML += `<option value="${annee.annee}">${annee.annee}</option>`;
    });
}

/*
// Exemple non utilisé : remplir la liste des départements
function recupDep(departements) {
    const dep = document.getElementById('departement');
    dep.innerHTML = '<option value="">-- Sélectionner --</option>';
    departements.forEach(departement => {
        dep.innerHTML += `<option value="${departement.dep_code}">${departement.dep_nom}</option>`;
    });
}
*/

/**
 * Filtre les coordonnées affichées sur la carte selon les filtres année et département.
 * @function
 * @param {Event} event - Événement du formulaire (click sur le bouton).
 */
function filtrerCoordonnees(event) {
    event.preventDefault();

    const annee = document.getElementById('annee').value;
    const dep = document.getElementById('departement').value;

    if (!annee || !dep) {
        alert("Veuillez sélectionner une année et un département.");
        return;
    }

    console.log("Filtrage - Année :", annee, "| Département :", dep);

    ajaxRequest('GET', `../php/request.php/lieu/coord?dep=${dep}&annee=${annee}`, ajoutCoord);
}

/**
 * Remplit la section de détails d'une installation photovoltaïque.
 * @function
 * @param {Object[]} data - Données détaillées de l'installation sélectionnée.
 */
function remplirDetailsVille(data) {
    console.log(data[0]['id'])
    if (!data) return;

    document.getElementById('lieu-value').textContent = data[0]['commune'] || "N/A";
    document.getElementById('nbPanneaux-value').textContent = data[0]['nb_panneaux'] || "N/A";
    document.getElementById('surface-value').textContent = data[0]['surface'] + " m²" || "N/A";
    document.getElementById('puissance-value').textContent = data[0]['puissance_crete'] + " kWc" || "N/A";

    const detailBtn = document.getElementById('detail-btn');
    detailBtn.href = `detail.html?id=${data[0]['id']}`;
}

/**
 * Fonction principale appelée au chargement de la page.
 * Initialise la carte, les filtres et les événements.
 * @function
 */
function main() {
    const currentPage = window.location.pathname.split("/").pop();

    document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });

    ajaxRequest('GET', '../php/request.php/date/annee', recupAnnee);
    // ajaxRequest('GET', '../php/request.php/lieu/departement', recupDep);

    initMap();

    const bouton = document.getElementById('search');
    if (bouton) {
        bouton.addEventListener('click', filtrerCoordonnees);
    } else {
        console.error("Le bouton #search est introuvable !");
    }

    $('#departement').select2({
        placeholder: "Rechercher un departement ...",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";

                if (query === '') {
                    url = `../php/request.php/lieu/departement`;
                } else {
                    url = `../php/request.php/lieu/departement?dep=${encodeURIComponent(query)}`;
                }

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
}

// Écouteur de chargement de la page
window.addEventListener("DOMContentLoaded", main);
