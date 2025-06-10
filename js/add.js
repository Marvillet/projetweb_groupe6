'use strict'
window.addEventListener("DOMContentLoaded", main);

function main() {
    definitionselect();
    let form = document.getElementById("installation-form");
    form.addEventListener("submit", addinstall)
}

function addinstall(event) {
    event.preventDefault();
    const formData = {
        mois_installation: document.getElementById('mois_installation').value,
        an_installation: document.getElementById('an_installation').value,
        nb_panneaux: document.getElementById('nb_panneaux').value,
        panneau_marque: $('#id_panneau_marque').val(),
        panneau_modele: $('#id_panneau_modele').val(),
        nb_onduleur: document.getElementById('nb_onduleur').value,
        onduleur_marque: $('#id_onduleur_marque').val(),
        onduleur_modele: $('#id_onduleur_modele').val(),
        puissance_crete: document.getElementById('puissance_crete').value,
        surface: document.getElementById('surface').value,
        orientation: document.getElementById('orientation').value,
        orientation_optimum: document.getElementById('orientation_opt').value,
        id_installateur: $('#id_installateur').val(),
        puissance_pvgis: document.getElementById('puissance_pvgis').value,
        lat: document.getElementById('lat').value,
        lon: document.getElementById('lon').value,
        code_insee: $('#code_insee').val(), // localisation
        pente: document.getElementById('pente').value,
        pente_optimum: document.getElementById('pente_optimum').value
    };
    console.log(formData);
}

function definitionselect() {
    $('#id_installateur').select2({
        width: '100%',
        placeholder: "Rechercher un installateur",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";
                if (query === '') {
                    url = '../php/request.php/installateur';
                } else {
                    url = `../php/request.php/installateur?filtre=${encodeURIComponent(query)}`;
                }

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_installateur,
                        text: item.installateurs
                    }));
                    success({
                        results: formattedResults
                    });
                }, failure); // Pass failure callback to ajaxRequest
            },
            cache: true // Important for performance
        },
        // ** Crucial part for displaying selected value **
        templateSelection: function (data) {
            // If data has 'text' property, use it. This is for results from AJAX.
            if (data.text) {
                return data.text;
            }
            // If data has 'id' but no 'text' (e.g., pre-existing value loaded from DB)
            // you might need to fetch the text, or assume it's already there from initial option load.
            // For pre-existing values, we'll manually add the option in modification.js
            return data.id; // Fallback to ID if text isn't directly available yet
        },
        templateResult: function (data) {
            return data.text;
        }
    });

    // You will need to apply similar templateSelection and templateResult logic
    // to your other Select2 instances (code_insee, id_panneau_marque, etc.)
    // if you encounter the same issue with them.

    $('#code_insee').select2({
        width: '100%',
        placeholder: "Rechercher une commune",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";
                if (query === '') {
                    url = '../php/request.php/lieu/commune';
                } else {
                    url = `../php/request.php/lieu/commune?commune=${encodeURIComponent(query)}`;
                }

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.code_insee,
                        text: item.nom_standard + "( " + item.code_postal + " )"
                    }));
                    success({
                        results: formattedResults
                    });
                }, failure);
            },
            cache: true
        },
        templateSelection: function (data) {
            return data.text || data.id;
        },
        templateResult: function (data) {
            return data.text;
        }
    });

    $('#id_panneau_marque').select2({
        width: '100%',
        placeholder: "Rechercher une marque de panneau", // Corrected placeholder
        dropdownPosition: 'below',
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";
                if (query === '') {
                    url = '../php/request.php/panneau/marque';
                } else {
                    url = `../php/request.php/panneau/marque?marque=${encodeURIComponent(query)}`;
                }

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_panneau_marque,
                        text: item.panneau_marque
                    }));
                    success({
                        results: formattedResults
                    });
                }, failure);
            },
            cache: true
        },
        templateSelection: function (data) {
            return data.text || data.id;
        },
        templateResult: function (data) {
            return data.text;
        }
    });

    $('#id_panneau_modele').select2({
        width: '100%',
        placeholder: "Rechercher un modèle de panneau", // Corrected placeholder
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";
                if (query === '') {
                    url = '../php/request.php/panneau/modele';
                } else {
                    url = `../php/request.php/panneau/modele?modele=${encodeURIComponent(query)}`;
                }

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_panneau_modele,
                        text: item.panneau_modele
                    }));
                    success({
                        results: formattedResults
                    });
                }, failure);
            },
            cache: true
        },
        templateSelection: function (data) {
            return data.text || data.id;
        },
        templateResult: function (data) {
            return data.text;
        }
    });

    $('#id_onduleur_marque').select2({
        width: '100%',
        placeholder: "Rechercher une marque d'onduleur", // Corrected placeholder
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";
                if (query === '') {
                    url = '../php/request.php/onduleur/marque';
                } else {
                    url = `../php/request.php/onduleur/marque?marque=${encodeURIComponent(query)}`;
                }

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_onduleur_marque,
                        text: item.onduleur_marque
                    }));
                    success({
                        results: formattedResults
                    });
                }, failure);
            },
            cache: true
        },
        templateSelection: function (data) {
            return data.text || data.id;
        },
        templateResult: function (data) {
            return data.text;
        }
    });

    $('#id_onduleur_modele').select2({
        width: '100%',
        placeholder: "Rechercher un modèle d'onduleur", // Corrected placeholder
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";
                if (query === '') {
                    url = '../php/request.php/onduleur/modele';
                } else {
                    url = `../php/request.php/onduleur/modele?modele=${encodeURIComponent(query)}`;
                }

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.id_onduleur_modele,
                        text: item.onduleur_modele
                    }));
                    success({
                        results: formattedResults
                    });
                }, failure);
            },
            cache: true
        },
        templateSelection: function (data) {
            return data.text || data.id;
        },
        templateResult: function (data) {
            return data.text;
        }
    });
}