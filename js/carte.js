'use strict'

function showInfo(){
    const info = document.getElementById('info');
    if (info.style.display === 'none' || info.style.display === '') {
        info.style.display = 'block';
    } else {
        info.style.display = 'none';
    }
}

function hideInfo() {
    const info = document.getElementById('info');
    info.style.display = 'none';
}

function ajoutCoord(data){
    // Initialisation de la carte centrée sur la France
    const map = L.map('map').setView([46.603354, 1.888334], 6);

    // Couche OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Marqueur de test
    data.forEach(dt => {
        L.marker([dt.lat,dt.lon])
            .addTo(map)
            .bindPopup('<b>Installation photovoltaïque</b><br>Marseille<br><button class="showInfo" onclick="showInfo()">Voir détail</button>');
    })
}

function main(){
    ajaxRequest('GET','php/request.php/lieu/coord?dep='+dep+'&annee='+annee,ajoutCoord)
}
window.addEventListener("DOMContentLoaded", main)