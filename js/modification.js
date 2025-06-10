'use strict';

document.addEventListener("DOMContentLoaded", () => {
    let form =document.getElementById("installation-form");
    form.addEventListener("submit",addinstall);
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

        // Updated mapping to use 'id' attributes from modif.php
        const mapping = {
            mois_installation: 'mois_installation',
            an_installation: 'an_installation',
            nb_panneaux: 'nb_panneaux',
            id_panneau_marque: 'panneau_marque', // Changed to id_panneau_marque
            id_panneau_modele: 'panneau_modele', // Changed to id_panneau_modele
            nb_onduleur: 'nb_onduleur',       // Changed to nb_onduleur
            id_onduleur_marque: 'onduleur_marque', // Changed to id_onduleur_marque
            id_onduleur_modele: 'onduleur_modele', // Changed to id_onduleur_modele
            puissance_crete: 'puissance_crete',
            surface: 'surface',
            orientation: 'orientation',
            orientation_opt: 'orientation_optimum',
            id_installateur: 'installateur',    // Changed to id_installateur
            puissance_pvgis: 'puissance_pvgis',
            lat: 'lat',                       // Changed to lat
            lon: 'lon',                       // Changed to lon
            code_insee: 'commune',          // Changed to code_insee (assuming 'commune' from data maps to this select)
            pente: 'pente',
            pente_optimum: 'pente_optimum'    // Changed to pente_optimum
        };

        for (const [inputId, dataKey] of Object.entries(mapping)) {
            const input = document.getElementById(inputId); // Select by ID
            if (input && data[dataKey] !== undefined) {
                input.value = data[dataKey];
                // For select2 elements, trigger change to update display
                if ($(input).hasClass('select2-hidden-accessible')) {
                    $(input).trigger('change');
                }
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("installation-form");
    const id = new URLSearchParams(window.location.search).get("id");
    if (!id) return;

    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const data = {};
        const formElements = form.querySelectorAll('input, select');
        formElements.forEach(element => {
            if (element.id) { // Use ID as the key for the data object
                data[element.id] = element.value;
            }
        });

        // Some fields in the `mapping` object (e.g., id_panneau_marque) might have different keys in the
        // backend compared to the frontend IDs. Ensure the `data` object sent in the PUT request
        // uses the keys expected by the backend. Based on your current `mapping`, it seems
        // the backend expects keys like `panneau_marque`, `panneau_modele`, etc.
        // You might need to adjust the `data` object to match the backend's expected keys.
        // For example:
        const finalData = {
            mois_installation: data.mois_installation,
            an_installation: data.an_installation,
            nb_panneaux: data.nb_panneaux,
            panneau_marque: data.id_panneau_marque, // Assuming backend expects 'panneau_marque'
            panneau_modele: data.id_panneau_modele,
            nb_onduleur: data.nb_onduleur,
            onduleur_marque: data.id_onduleur_marque,
            onduleur_modele: data.id_onduleur_modele,
            puissance_crete: data.puissance_crete,
            surface: data.surface,
            orientation: data.orientation,
            orientation_optimum: data.orientation_opt,
            installateur: data.id_installateur,
            puissance_pvgis: data.puissance_pvgis,
            lat: data.lat,
            lon: data.lon,
            commune: data.code_insee, // Assuming backend expects 'commune'
            pente: data.pente,
            pente_optimum: data.pente_optimum
        };


        ajaxRequest2("PUT", `../php/request.php/admin/${id}`, function (response, status) {
            if (status === 200) {
                alert("Installation modifiée avec succès !");
                window.location.href = "../back/admin.php";
            } else {
                alert("Erreur lors de la modification.");
                console.error("Réponse serveur : ", response);
            }
        }, new URLSearchParams(finalData).toString()); // Convert object to URL-encoded string
    });
});

function addinstall(event){
    event.preventDefault();
    const formData = {
        mois_installation: document.getElementById('mois_installation').value,
        an_installation: document.getElementById('an_installation').value,
        nb_panneaux: document.getElementById('nb_panneaux').value,
        // For standard selects, just use .value
        panneau_marque: document.getElementById('id_panneau_marque').value,
        panneau_modele: document.getElementById('id_panneau_modele').value,
        nb_onduleur: document.getElementById('nb_onduleur').value,
        onduleur_marque: document.getElementById('id_onduleur_marque').value,
        onduleur_modele: document.getElementById('id_onduleur_modele').value,
        puissance_crete: document.getElementById('puissance_crete').value,
        surface: document.getElementById('surface').value,
        orientation: document.getElementById('orientation').value,
        orientation_optimum: document.getElementById('orientation_opt').value,
        // For standard selects, just use .value
        id_installateur: document.getElementById('id_installateur').value,
        puissance_pvgis: document.getElementById('puissance_pvgis').value,
        lat: document.getElementById('lat').value,
        lon: document.getElementById('lon').value,
        // For standard selects, just use .value
        code_insee: document.getElementById('code_insee').value, // localisation
        pente: document.getElementById('pente').value,
        pente_optimum: document.getElementById('pente_optimum').value
    };
    console.log(formData);
}

