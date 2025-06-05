'use strict'

function getselect($data){
    let select=document.getElementById("panneau");
    let text="<option value=\"\">-- Toutes les marques --</option>";
    $data.forEach((value)=>{
        text+="<option id='"+value["id_panneau_marque"]+"'>"+value["panneau_marque"]+"</option>";
    })
    select.innerHTML=text;
}
function recherche(){
    document
}

window.addEventListener("DOMContentLoaded",()=>{
    document.getElementById("search").addEventListener("submit",(event)=>{
        event.preventDefault()

    })
    $('#panneau').select2({
        placeholder: "Rechercher une marque...",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";
                if (query === '') {
                    url = `../php/request.php/panneau/marque`;
                } else {
                    url = `../php/request.php/panneau/marque?marque=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {
                    // 👇 s'assurer que response est bien un tableau
                    const formattedResults = response.map(item => ({
                        id: item.id_panneau_marque,
                        text: item.panneau_marque
                    }));

                    success({
                        results: formattedResults
                    })

                })
            }
        }
    });
    $('#onduleur').select2({
        placeholder: "Rechercher une marque...",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";
                if (query === '') {
                    url = `../php/request.php/onduleur/marque`;
                } else {
                    url = `../php/request.php/onduleur/marque?marque=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {
                    // 👇 s'assurer que response est bien un tableau
                    const formattedResults = response.map(item => ({
                        id: item.id_onduleur_marque,
                        text: item.onduleur_marque
                    }));

                    success({
                        results: formattedResults
                    })

                })
            }
        }
    });
    $('#departement').select2({
        placeholder: "Rechercher un departement ...",
        ajax: {
            transport: function (params, success, failure) {
                const query = params.data.term || '';
                let url = "";
                if (query === '') {
                    url = `../php/request.php/lieu/departement`;
                } else {
                    url = `../php/request.php/lieu/departement?dep=${encodeURIComponent(query)}`;

                }

                ajaxRequest('GET', url, function (response) {
                    const formattedResults = response.map(item => ({
                        id: item.dep_code,
                        text: item.dep_nom
                    }));

                    success({
                        results: formattedResults
                    })

                })
            }
        }
    });
});