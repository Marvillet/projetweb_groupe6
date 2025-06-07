'use strict'

document.addEventListener("DOMContentLoaded", () => {
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

        const mapping = {
            mois_installation: 'mois_installation',
            an_installation: 'an_installation',
            nb_panneaux: 'nb_panneaux',
            marque_panneaux: 'panneau_marque',
            modele_panneaux: 'panneau_modele',
            nb_onduleurs: 'nb_onduleur',
            marque_onduleur: 'onduleur_marque',
            modele_onduleur: 'onduleur_modele',
            puissance_crete: 'puissance_crete',
            surface: 'surface',
            pente: 'pente',
            orientation: 'orientation',
            orientation_opt: 'orientation_optimum',
            installateur: 'installateur',
            pvgis: 'puissance_pvgis',
            latitude: 'lat',
            longitude: 'lon',
            pays: 'pays',
            code_postal: 'code_postal',
            localite: 'commune',
            region: 'region',
            departement: 'departement'
        };

        for (const [inputName, dataKey] of Object.entries(mapping)) {
            const input = document.querySelector(`[name="${inputName}"]`);
            if (input && data[dataKey] !== undefined) {
                input.value = data[dataKey];
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

        const formData = new FormData(form);
        const data = new URLSearchParams();

        for (const [key, value] of formData.entries()) {
            data.append(key, value);
        }

        ajaxRequest2("PUT", `../php/request.php/admin/${id}`, function (response, status) {
            if (status === 200) {
                alert("Installation modifiée avec succès !");
                window.location.href = "../back/admin.php";
            } else {
                alert("Erreur lors de la modification.");
                console.error("Réponse serveur : ", response);
            }
        }, data.toString());
    });
});
