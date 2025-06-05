'use strict'

window.addEventListener("DOMContentLoaded", main);

function main() {
    const id = getIdFromUrl();
    console.log(`Appel API pour l'installation ID=${id}`);
    ajaxRequest("GET", `../php/request.php/installation/${id}`, remplirDetails);
}

function getIdFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get("id");
}

function remplirDetails(data) {
    if (!data) return;

    const list1 = document.querySelectorAll(".list-group")[0].children;
    const list2 = document.querySelectorAll(".list-group")[1].children;

    // Colonne 1
    list1[0].innerHTML = `<strong>Mois d'installation :</strong> ${data.mois_installation}`;
    list1[1].innerHTML = `<strong>Année d'installation :</strong> ${data.annee_installion}`;
    list1[2].innerHTML = `<strong>Nombre de panneaux :</strong> ${data.nb_panneaux}`;
    list1[3].innerHTML = `<strong>Marque des panneaux :</strong> ${data.panneau_marque}`;
    list1[4].innerHTML = `<strong>Modèle des panneaux :</strong> ${data.panneau_modele}`;
    list1[5].innerHTML = `<strong>Marque onduleur :</strong> ${data.onduleur_marque}`;
    list1[6].innerHTML = `<strong>Modèle onduleur :</strong> ${data.onduleur_modele}`;
    list1[7].innerHTML = `<strong>Puissance crête :</strong> ${data.puissance_crete} kWc`;
    list1[8].innerHTML = `<strong>Surface :</strong> ${data.surface} m²`;
    list1[9].innerHTML = `<strong>Pente :</strong> ${data.pente}°`;
    list1[10].innerHTML = `<strong>Pente optimale :</strong> ${data.pente_optimum}°`;

    // Colonne 2
    list2[0].innerHTML = `<strong>Orientation :</strong> ${data.orientation}`;
    list2[1].innerHTML = `<strong>Orientation optimale :</strong> ${data.orientation_optimum}`;
    list2[2].innerHTML = `<strong>Installateur :</strong> ${data.installateur}`;
    list2[3].innerHTML = `<strong>Production PVGIS estimée :</strong> ${data.puissance_pvgis}`;
    list2[4].innerHTML = `<strong>Latitude :</strong> ${data.lat}`;
    list2[5].innerHTML = `<strong>Longitude :</strong> ${data.long}`;
    list2[6].innerHTML = `<strong>Pays :</strong> ${data.pays}`;
    list2[7].innerHTML = `<strong>Code postal :</strong> ${data.code_postal}`;
    list2[8].innerHTML = `<strong>Ville :</strong> ${data.commune}`;
    list2[9].innerHTML = `<strong>Région :</strong> ${data.region}`;
    list2[10].innerHTML = `<strong>Département :</strong> ${data.departement}`;

    // Mettre à jour la carte Google
    updateMap(data.lat, data.lon);
}

function updateMap(lat, lon) {
    const iframe = document.querySelector("iframe");
    if (iframe && lat && lon) {
        iframe.src = `https://maps.google.com/maps?q=${lat},${lon}&z=15&output=embed`;
    }
}