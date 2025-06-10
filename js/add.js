'use strict'
window.addEventListener("DOMContentLoaded",main);
let toastEl;
let toast;
function main(){
    toastEl = document.getElementById("toast-msg");
    toast = new bootstrap.Toast(toastEl);

    definitionselect();
    let form =document.getElementById("installation-form");
    form.addEventListener("submit",addinstall);


}
function addinstall(event){
    event.preventDefault();
    const formData = {
        mois_installation: document.getElementById('mois_installation').value,
        an_installation: document.getElementById('an_installation').value,
        nb_panneaux: document.getElementById('nb_panneaux').value,
        id_panneau_marque: $('#id_panneau_marque').val(),
        id_panneau_modele: $('#id_panneau_modele').val(),
        nb_onduleur: document.getElementById('nb_onduleur').value,
        id_onduleur_marque: $('#id_onduleur_marque').val(),
        id_onduleur_modele: $('#id_onduleur_modele').val(),
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
    console.log(encodeFormData(formData));
    ajaxRequest2('POST',"../php/request.php/admin",affichetoast,encodeFormData(formData))
}
function affichetoast(message, status){
    toastEl.classList.remove("bg-success", "bg-danger");
    if(status===201 || status===200){
        toastEl.classList.add("bg-success");
        toastEl.querySelector(".toast-body").textContent = message;
    }
    else{
        toastEl.classList.add("bg-danger");
        toastEl.querySelector(".toast-body").textContent = "Erreur ajout";
    }
    toast.show();
}
function definitionselect(){
    $('#id_installateur').select2({
        //Z index à mettre par dessus le modal pour pouvoir voir les options
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
    $('#code_insee').select2({
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
    $('#id_panneau_marque').select2({
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
    $('#id_panneau_modele').select2({
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
    $('#id_onduleur_marque').select2({
        width: '100%', //Forcer à occuper toute la largeur du parent
        placeholder: "Rechercher un installateur",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';//récupère le texte
                let url = "";
                //l'url change en fonction de si un texte à commecer à être tapé
                if (query === '') {
                    url = '../php/request.php/onduleur/marque';
                } else {
                    url = `../php/request.php/onduleur/marque?marque=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {

                    // s'assurer que response est bien un tableau
                    const formattedResults = response.map(item => ({
                        id: item.id_onduleur_marque, //id de l'option
                        text: item.onduleur_marque //text afficher
                    }));
                    console.log(formattedResults);
                    success({
                        results: formattedResults
                    })

                })
            }
        }
    });
    $('#id_onduleur_modele').select2({
        width: '100%', //Forcer à occuper toute la largeur du parent
        placeholder: "Rechercher un installateur",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';//récupère le texte
                let url = "";
                //l'url change en fonction de si un texte à commecer à être tapé
                if (query === '') {
                    url = '../php/request.php/onduleur/modele';
                } else {
                    url = `../php/request.php/onduleur/modele?modele=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {

                    // s'assurer que response est bien un tableau
                    const formattedResults = response.map(item => ({
                        id: item.id_onduleur_modele, //id de l'option
                        text: item.onduleur_modele //text afficher
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