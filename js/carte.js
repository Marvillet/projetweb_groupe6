'use strict'

let map; // variable globale pour garder une seule instance de carte

function showInfo() {
    const info = document.getElementById('info');
    info.style.display = (info.style.display === 'none' || info.style.display === '') ? 'block' : 'none';
}

function hideInfo() {
    const info = document.getElementById('info');
    info.style.display = 'none';
}

function initMap() {
    map = L.map('map').setView([46.603354, 1.888334], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
}

function ajoutCoord(data) {
    if (!map) {
        initMap();
    }

    // Supprime tous les anciens marqueurs
    map.eachLayer(layer => {
        if (layer instanceof L.Marker) {
            map.removeLayer(layer);
        }
    });

    data.forEach(dt => {
        L.marker([dt.lat, dt.lon])
            .addTo(map)
            .bindPopup('<b>Installation photovoltaïque</b><br>Localisation inconnue<br><button class="showInfo" onclick="showInfo()">Voir détail</button>');
    });
}

// ==== Remplissage dynamique des <select> + stats associées ====

function recupAnnee(annees) {
    const an = document.getElementById('annee');
    an.innerHTML = '';
    annees.forEach(annee => {
        an.innerHTML += `<option value="${annee.annee}">${annee.annee}</option>`;
    });
}

function recupDep(departements) {
    const dep = document.getElementById('departement');
    dep.innerHTML = '';
    departements.forEach(departement => {
        dep.innerHTML += `<option value="${departement.dep_code}">${departement.dep_nom}</option>`;
    });
}

function filtrerCoordonnees() {
    const annee = document.getElementById('annee').value;
    const dep = document.getElementById('departement').value;

    console.log("Année :", annee);
    console.log("Département :", dep);

    ajaxRequest('GET', `../php/request.php/lieu/coord?dep=${dep}&annee=${annee}`, ajoutCoord);
}

function main() {
    ajaxRequest('GET', '../php/request.php/date/annee', recupAnnee);
    ajaxRequest('GET', '../php/request.php/lieu/departement', recupDep);

    // Initialise la carte au démarrage
    initMap();

    // Vérifie que le bouton existe bien
    const bouton = document.getElementById('search');
    if (bouton) {
        bouton.addEventListener('click', filtrerCoordonnees);
    } else {
        console.error("Le bouton avec l'id 'search' est introuvable.");
    }
}

window.addEventListener("DOMContentLoaded", main);
