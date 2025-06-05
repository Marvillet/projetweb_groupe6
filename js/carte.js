function showInfo() {
    const info = document.getElementById('info');
    info.style.display = (info.style.display === 'none' || info.style.display === '') ? 'block' : 'none';
}

function hideInfo() {
    const info = document.getElementById('info');
    info.style.display = 'none';
}
const fakeData = [
    { lat: 43.2965, lon: 5.3698 }, // Marseille
    { lat: 48.8566, lon: 2.3522 }  // Paris
];

function ajoutCoord(data) {
    console.log("Données reçues :", data);
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

function main() {
    ajaxRequest('GET','../php/request.php/lieu/coord?dep=14&annee=2010',ajoutCoord)
}

window.addEventListener("DOMContentLoaded", main);