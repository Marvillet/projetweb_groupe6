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
    const mois = [
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre"
    ];
    if (!data) return;

    const list1 = document.querySelectorAll(".list-group")[0].children;
    const list2 = document.querySelectorAll(".list-group")[1].children;

    // Colonne 1
    list1[0].innerHTML = `<strong>Mois d'installation :</strong> ${mois[data[0]['mois_installation']]}`;
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

    // Colonne 2
    list2[0].innerHTML = `<strong>Orientation :</strong> ${data[0]['orientation']}`;
    list2[1].innerHTML = `<strong>Orientation optimale :</strong> ${data[0]['orientation_optimum']}`;
    list2[2].innerHTML = `<strong>Installateur :</strong> ${data[0]['installateur']}`;
    list2[3].innerHTML = `<strong>Production PVGIS estimée :</strong> ${data[0]['puissance_pvgis']}`;
    list2[4].innerHTML = `<strong>Latitude :</strong> ${data[0]['lat']}`;
    list2[5].innerHTML = `<strong>Longitude :</strong> ${data[0]['long']}`;
    list2[6].innerHTML = `<strong>Pays :</strong> ${data[0]['pays']}`;
    list2[7].innerHTML = `<strong>Code postal :</strong> ${data[0]['code_postal']}`;
    list2[8].innerHTML = `<strong>Ville :</strong> ${data[0]['commune']}`;
    list2[9].innerHTML = `<strong>Région :</strong> ${data[0]['region']}`;
    list2[10].innerHTML = `<strong>Département :</strong> ${data[0]['departement']}`;

    // Mettre à jour la carte Google
    updateMap(data.lat, data.lon);
}

function updateMap(lat, lon) {
    const iframe = document.querySelector("iframe");
    if (iframe && lat && lon) {
        iframe.src = `https://maps.google.com/maps?q=${lat},${lon}&z=15&output=embed`;
    }
}