'use strict';

document.addEventListener("DOMContentLoaded", () => {
    const id = new URLSearchParams(window.location.search).get("id");
    if (!id) return;

    // Function to populate select2 dropdowns
    // (You might already have these in add.js or ajax.js)
    function populateSelect2(selector, url, idField, textField, initialValue = null) {
        $(selector).select2({
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item[idField],
                            text: item[textField]
                        }))
                    };
                },
                cache: true
            },
            placeholder: 'Sélectionnez une option',
            minimumInputLength: 0 // Allow displaying all options on focus if desired
        });

        // Set initial value if provided
        if (initialValue) {
            // Fetch the text for the initial value if not already in the options
            $.ajax({
                type: 'GET',
                url: url,
                data: { id: initialValue } // Assuming your API can fetch by ID
            }).then(function (data) {
                if (data && data.length > 0) {
                    const option = new Option(data[0][textField], data[0][idField], true, true);
                    $(selector).append(option).trigger('change');
                }
            });
        }
    }


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
            id_panneau_marque: 'panneau_marque',
            id_panneau_modele: 'panneau_modele',
            nb_onduleur: 'nb_onduleur',
            id_onduleur_marque: 'onduleur_marque',
            id_onduleur_modele: 'onduleur_modele',
            puissance_crete: 'puissance_crete',
            surface: 'surface',
            orientation: 'orientation',
            orientation_opt: 'orientation_optimum',
            id_installateur: 'installateur',
            puissance_pvgis: 'puissance_pvgis',
            lat: 'lat',
            lon: 'lon',
            code_insee: 'commune', // Assuming 'commune' from data maps to code_insee
            pente: 'pente',
            pente_optimum: 'pente_optimum'
        };

        // Populate standard input fields
        for (const [inputId, dataKey] of Object.entries(mapping)) {
            const input = document.getElementById(inputId);
            if (input && data[dataKey] !== undefined) {
                if (!$(input).hasClass('select2-hidden-accessible')) { // Only set value for non-select2
                    input.value = data[dataKey];
                }
            }
        }

        // --- Handle Select2 fields specifically after data is fetched ---

        // Example for id_panneau_marque (adjust URLs and fields as per your backend)
        if (data.panneau_marque) {
            populateSelect2(
                '#id_panneau_marque',
                '../php/request.php/marques_panneaux', // Example URL for panel brands
                'id_marque_panneau', // Field in your API response that is the ID
                'nom_marque_panneau', // Field in your API response that is the name
                data.panneau_marque
            );
        } else {
            populateSelect2(
                '#id_panneau_marque',
                '../php/request.php/marques_panneaux',
                'id_marque_panneau',
                'nom_marque_panneau'
            );
        }


        // Example for id_panneau_modele (will depend on selected brand if linked)
        // If id_panneau_modele depends on id_panneau_marque, you'll need to
        // trigger its population after id_panneau_marque is set and potentially after its change.
        // For now, assuming it can be populated independently with its own value:
        if (data.panneau_modele) {
            populateSelect2(
                '#id_panneau_modele',
                '../php/request.php/modeles_panneaux', // Example URL for panel models
                'id_modele_panneau', // Field in your API response that is the ID
                'nom_modele_panneau', // Field in your API response that is the name
                data.panneau_modele
            );
        } else {
            populateSelect2(
                '#id_panneau_modele',
                '../php/request.php/modeles_panneaux',
                'id_modele_panneau',
                'nom_modele_panneau'
            );
        }


        // Repeat for Onduleur Marque, Onduleur Modele, and code_insee
        if (data.onduleur_marque) {
            populateSelect2(
                '#id_onduleur_marque',
                '../php/request.php/marques_onduleurs', // Example URL
                'id_marque_onduleur',
                'nom_marque_onduleur',
                data.onduleur_marque
            );
        } else {
            populateSelect2(
                '#id_onduleur_marque',
                '../php/request.php/marques_onduleurs',
                'id_marque_onduleur',
                'nom_marque_onduleur'
            );
        }

        if (data.onduleur_modele) {
            populateSelect2(
                '#id_onduleur_modele',
                '../php/request.php/modeles_onduleurs', // Example URL
                'id_modele_onduleur',
                'nom_modele_onduleur',
                data.onduleur_modele
            );
        } else {
            populateSelect2(
                '#id_onduleur_modele',
                '../php/request.php/modeles_onduleurs',
                'id_modele_onduleur',
                'nom_modele_onduleur'
            );
        }

        if (data.commune) {
            populateSelect2(
                '#code_insee',
                '../php/request.php/communes', // Example URL for communes
                'code_insee', // Field in your API response that is the ID
                'nom_commune', // Field in your API response that is the name (e.g., "ville (code_postal)")
                data.commune
            );
        } else {
            populateSelect2(
                '#code_insee',
                '../php/request.php/communes',
                'code_insee',
                'nom_commune'
            );
        }

        // Special handling for id_installateur if it's a simple text input or a Select2 based on specific data
        const installateurInput = document.getElementById('id_installateur');
        if (installateurInput && data.installateur !== undefined) {
            installateurInput.value = data.installateur;
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

        // Map frontend IDs to backend expected keys for the PUT request
        const finalData = {
            mois_installation: data.mois_installation,
            an_installation: data.an_installation,
            nb_panneaux: data.nb_panneaux,
            panneau_marque: data.id_panneau_marque,
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
            commune: data.code_insee, // Assuming backend expects 'commune' for code_insee
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
        }, new URLSearchParams(finalData).toString());
    });
});