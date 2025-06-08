'use strict'
window.addEventListener("DOMContentLoaded",main);
function definitionselect(){
    $('#installateur-name').select2({
        //Z index à mettre par dessus le modal pour pouvoir voir les options
        dropdownParent: $('#installationModal'),
        width: '100%', //Forcer à occuper toute la largeur du parent
        placeholder: "Rechercher un installateur",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';//récupère le texte
                let url = "";
                //l'url change en fonction de si un texte à commecer à être tapé
                if (query === '') {
                    url = '../php/request.php/installateur';
                } else {
                    url = `../php/request.php/installateur?filtre=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {

                    // s'assurer que response est bien un tableau
                    const formattedResults = response.map(item => ({
                        id: item.id_installateur, //id de l'option
                        text: item.installateurs //text afficher
                    }));
                    console.log(formattedResults);
                    success({
                        results: formattedResults
                    })

                })
            }
        }
    });
    $('#install-commune').select2({
        //Z index à mettre par dessus le modal pour pouvoir voir les options
        dropdownParent: $('#installationModal'),
        width: '100%', //Forcer à occuper toute la largeur du parent
        placeholder: "Rechercher une commune",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';//récupère le texte
                let url = "";
                //l'url change en fonction de si un texte à commecer à être tapé
                if (query === '') {
                    url = '../php/request.php/lieu/commune';
                } else {
                    url = `../php/request.php/lieu/commune?commune=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {

                    // s'assurer que response est bien un tableau
                    const formattedResults = response.map(item => ({
                        id: item.code_insee, //id de l'option
                        text: item.nom_standard+"( "+item.code_postal+" )" //text afficher
                    }));
                    console.log(formattedResults);
                    success({
                        results: formattedResults
                    })

                })
            }
        }
    });
    $('#install-marquePanneaux').select2({
        //Z index à mettre par dessus le modal pour pouvoir voir les options
        dropdownParent: $('#installationModal'),
        width: '100%', //Forcer à occuper toute la largeur du parent
        placeholder: "Rechercher un installateur",
        dropdownPosition: 'below',
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';//récupère le texte
                let url = "";
                //l'url change en fonction de si un texte à commecer à être tapé
                if (query === '') {
                    url = '../php/request.php/panneau/marque';
                } else {
                    url = `../php/request.php/panneau/marque?marque=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {

                    // s'assurer que response est bien un tableau
                    const formattedResults = response.map(item => ({
                        id: item.id_panneau_marque, //id de l'option
                        text: item.panneau_marque //text afficher
                    }));
                    console.log(formattedResults);
                    success({
                        results: formattedResults
                    })

                })
            }
        }
    });
    $('#install-modelePanneaux').select2({
        //Z index à mettre par dessus le modal pour pouvoir voir les options
        dropdownParent: $('#installationModal'),
        width: '100%', //Forcer à occuper toute la largeur du parent
        placeholder: "Rechercher un installateur",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';//récupère le texte
                let url = "";
                //l'url change en fonction de si un texte à commecer à être tapé
                if (query === '') {
                    url = '../php/request.php/panneau/modele';
                } else {
                    url = `../php/request.php/panneau/modele?modele=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {

                    // s'assurer que response est bien un tableau
                    const formattedResults = response.map(item => ({
                        id: item.id_panneau_modele, //id de l'option
                        text: item.panneau_modele //text afficher
                    }));
                    console.log(formattedResults);
                    success({
                        results: formattedResults
                    })

                })
            }
        }
    });
    $('#install-modelePanneaux').select2({
        //Z index à mettre par dessus le modal pour pouvoir voir les options
        dropdownParent: $('#installationModal'),
        width: '100%', //Forcer à occuper toute la largeur du parent
        placeholder: "Rechercher un installateur",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';//récupère le texte
                let url = "";
                //l'url change en fonction de si un texte à commecer à être tapé
                if (query === '') {
                    url = '../php/request.php/panneau/modele';
                } else {
                    url = `../php/request.php/panneau/modele?modele=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {

                    // s'assurer que response est bien un tableau
                    const formattedResults = response.map(item => ({
                        id: item.id_panneau_modele, //id de l'option
                        text: item.panneau_modele //text afficher
                    }));
                    console.log(formattedResults);
                    success({
                        results: formattedResults
                    })

                })
            }
        }
    });
}
function main(){
    definitionselect();
}
