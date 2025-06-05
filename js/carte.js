'use strict';

let map;
let markersLayer; // Pour regrouper tous les marqueurs

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

    markersLayer = L.layerGroup().addTo(map);
}

function ajoutCoord(data) {
    // Référence au message
    const messageDiv = document.getElementById('message');

    // Efface tous les anciens marqueurs
    markersLayer.clearLayers();

    if (data.length === 0) {
        // Aucun résultat
        messageDiv.classList.remove('d-none');
        messageDiv.classList.add('d-block');
        return;
    } else {
        // Résultats trouvés → on masque le message
        messageDiv.classList.add('d-none');
        messageDiv.classList.remove('d-block');
    }

    data.forEach(dt => {
        if (dt.lat && dt.lon) {
            const marker = L.marker([dt.lat, dt.lon])
                .bindPopup('<b>Installation photovoltaïque</b><br><button class="showInfo" onclick="showInfo()">Voir détail</button>');
            markersLayer.addLayer(marker);
        }
    });

    // Zoom automatique si des données sont présentes
    const bounds = L.latLngBounds(data.map(d => [d.lat, d.lon]));
    map.fitBounds(bounds, { padding: [50, 50] });
}


// ==== Remplissage dynamique des <select> ====

function recupAnnee(annees) {
    const an = document.getElementById('annee');
    an.innerHTML = '<option value="">-- Sélectionner --</option>';
    annees.forEach(annee => {
        an.innerHTML += `<option value="${annee.annee}">${annee.annee}</option>`;
    });
}

function recupDep(departements) {
    const dep = document.getElementById('departement');
    dep.innerHTML = '<option value="">-- Sélectionner --</option>';
    departements.forEach(departement => {
        dep.innerHTML += `<option value="${departement.dep_code}">${departement.dep_nom}</option>`;
    });
}

function filtrerCoordonnees(event) {
    event.preventDefault(); // ← important pour empêcher la soumission du formulaire

    const annee = document.getElementById('annee').value;
    const dep = document.getElementById('departement').value;

    if (!annee || !dep) {
        alert("Veuillez sélectionner une année et un département.");
        return;
    }

    console.log("Filtrage - Année :", annee, "| Département :", dep);

    ajaxRequest('GET', `../php/request.php/lieu/coord?dep=${dep}&annee=${annee}`, ajoutCoord);
}

function main() {

    ajaxRequest('GET', '../php/request.php/date/annee', recupAnnee);
    ajaxRequest('GET', '../php/request.php/lieu/departement', recupDep);

    initMap(); // Crée la carte une seule fois

    const bouton = document.getElementById('search');
    if (bouton) {
        bouton.addEventListener('click', filtrerCoordonnees);
    } else {
        console.error("Le bouton #search est introuvable !");
    }
}

window.addEventListener("DOMContentLoaded", main);
