'use strict'
function showInfo() {
    const info = document.getElementById('info');
    info.style.display = (info.style.display === 'none' || info.style.display === '') ? 'block' : 'none';
}

function hideInfo() {
    const info = document.getElementById('info');
    info.style.display = 'none';
}


function ajoutCoord(data) {

    const map = L.map('map').setView([46.603354, 1.888334], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    data.forEach(dt => {
        L.marker([dt.lat, dt.lon])
            .addTo(map)
            .bindPopup('<b>Installation photovoltaïque</b><br>Marseille<br><button class="showInfo" onclick="showInfo()">Voir détail</button>');
    });
}

// ==== Mises à jour des titres et stats ====

function updateYearStats(annee) {
    ajaxRequest('GET', '../php/request.php/stat/annee?id_an=' + annee, byYear);
    const titleByYear = document.getElementById('titleByYear');
    if (titleByYear) titleByYear.textContent = annee;
}

function updateDepartementStats(departement, departement_nom) {
    ajaxRequest('GET', '../php/request.php/stat/departement?id_dep=' + departement, byDepartement);
    const titleByDepartement = document.getElementById('titleByDepartement');
    if (titleByDepartement) titleByDepartement.textContent = departement_nom;
}

function updateDepartementYearStats(departement, departement_nom, annee) {
    ajaxRequest('GET', '../php/request.php/stat/an_dep?id_an=' + annee + '&id_dep=' + departement, byDepartementYear);
    const titleByDepartementYear = document.getElementById('titleByDepartementYear');
    if (titleByDepartementYear) titleByDepartementYear.textContent = departement_nom + ' en ' + annee;
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


function main() {
    ajaxRequest('GET','../php/request.php/lieu/coord?dep=14&annee=2010',ajoutCoord)
}
window.addEventListener("DOMContentLoaded", main);