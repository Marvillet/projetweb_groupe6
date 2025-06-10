'use strict';

document.addEventListener("DOMContentLoaded", () => {
    ajaxRequest("GET","../php/request.php/onduleur/marque",addMarqueO);
    ajaxRequest("GET","../php/request.php/onduleur/modele",addModeleO);
    ajaxRequest("GET","../php/request.php/panneau/marque",addMarqueP);
    ajaxRequest("GET","../php/request.php/panneau/modele",addModeleP);
    ajaxRequest("GET","../php/request.php/installateur",addInstallateur);
    ajaxRequest("GET","../php/request.php/lieu/commune",addComm);
    const id = new URLSearchParams(window.location.search).get("id");
    if (!id) return;

    ajaxRequest("GET", `../php/request.php/admin/${id}`, function(data) {
        if (Array.isArray(data) && data.length === 1) {
            data = data[0];
        }

        if (!data || typeof data !== "object") {
            console.warn("Format de réponse inattendu", data);
            alert("Erreur lors du chargement des données.");
            return;
        }

        const panMa = document.getElementById('id_panneau_marque');
        const panMo = document.getElementById('id_panneau_modele');
        const onMa = document.getElementById('id_onduleur_marque');
        const onMo = document.getElementById('id_onduleur_modele');
        const insta = document.getElementById('id_installateur');
        const comm = document.getElementById('code_insee');

        panMa.innerHTML+=`<option value="${data.id_panneau_marque}" selected>${data.panneau_marque}</option>`;
        panMo.innerHTML+=`<option value="${data.id_panneau_modele}" selected>${data.panneau_modele}</option>`;
        onMa.innerHTML+=`<option value="${data.id_onduleur_marque}" selected>${data.onduleur_marque}</option>`;
        onMo.innerHTML+=`<option value="${data.id_onduleur_modele}" selected>${data.onduleur_modele}</option>`;
        insta.innerHTML+=`<option value="${data.id_installateur}" selected>${data.installateur}</option>`;
        comm.innerHTML+=`<option value="${data.code_insee}" selected>${data.commune}</option>`;

        console.log(comm.value);

        const mapping = {
            mois_installation: 'mois_installation',
            an_installation: 'an_installation',
            nb_panneaux: 'nb_panneaux',
            nb_onduleur: 'nb_onduleur',
            puissance_crete: 'puissance_crete',
            surface: 'surface',
            orientation: 'orientation',
            orientation_opt: 'orientation_optimum',
            puissance_pvgis: 'puissance_pvgis',
            lat: 'lat',
            lon: 'lon',
            pente: 'pente',
            pente_optimum: 'pente_optimum'
        };

        for (const [inputId, dataKey] of Object.entries(mapping)) {
            const input = document.getElementById(inputId); // Select by ID
            if (input && data[dataKey] !== undefined) {
                input.value = data[dataKey];
                if ($(input).hasClass('select2-hidden-accessible')) {
                    $(input).trigger('change');
                }
            }
        }
    });

    const form = document.getElementById("installation-form");

    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const data = {};
        const formElements = form.querySelectorAll('input, select');
        formElements.forEach(element => {
            if (element.id) { // Use ID as the key for the data object
                data[element.id] = element.value;
            }
        });


        const finalData = {
            id: id,
            mois_installation: data.mois_installation,
            an_installation: data.an_installation,
            nb_panneaux: data.nb_panneaux,
            id_panneau_marque: data.id_panneau_marque,
            id_panneau_modele: data.id_panneau_modele,
            nb_onduleur: data.nb_onduleur,
            id_onduleur_marque: data.id_onduleur_marque,
            id_onduleur_modele: data.id_onduleur_modele,
            puissance_crete: data.puissance_crete,
            surface: data.surface,
            orientation: data.orientation,
            orientation_optimum: data.orientation_opt,
            id_installateur: data.id_installateur,
            puissance_pvgis: data.puissance_pvgis,
            lat: data.lat,
            lon: data.lon,
            code_insee: data.code_insee,
            pente: data.pente,
            pente_optimum: data.pente_optimum
        };

        ajaxRequest2("PUT", `../php/request.php/admin/${id}`, function (response, status) {
            if (status === 201) {
                alert("Installation modifiée avec succès !");
                window.location.href = "../back/admin.php";
            } else {
                alert("Erreur lors de la modification !");
                console.error("Réponse serveur : ", response);
            }
        }, encodeFormData(finalData));
    });
});


function addMarqueP(data){
    const select = document.getElementById('id_panneau_marque');
    data.forEach(dat => {
        select.innerHTML += `<option value="${dat.id_panneau_marque}">${dat.panneau_marque}</option>`;
    });
}
function addModeleP(data){
    const select = document.getElementById('id_panneau_modele');
    data.forEach(dat => {
        select.innerHTML += `<option value="${dat.id_panneau_modele}">${dat.panneau_modele}</option>`;
    });
}
function addMarqueO(data){
    const select = document.getElementById('id_onduleur_marque');
    data.forEach(dat => {
        select.innerHTML += `<option value="${dat.id_onduleur_marque}">${dat.onduleur_marque}</option>`;
    });
}
function addModeleO(data){
    const select = document.getElementById('id_onduleur_modele');
    data.forEach(dat => {
        select.innerHTML += `<option value="${dat.id_onduleur_modele}">${dat.onduleur_modele}</option>`;
    });
}

function addInstallateur(data){
    const select = document.getElementById('id_installateur');
    data.forEach(dat => {
        select.innerHTML += `<option value="${dat.id_installateur}">${dat.installateurs}</option>`;
    });
}

function addComm(data){
    const select = document.getElementById('code_insee');
    data.forEach(dat => {
        select.innerHTML += `<option value="${dat.code_insee}">${dat.nom_standard}</option>`;
    });
}