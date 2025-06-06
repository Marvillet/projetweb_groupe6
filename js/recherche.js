'use strict'

function getselect(data){
    let select=document.getElementById("panneau");
    let text="<option value=\"\">-- Toutes les marques --</option>";
    data.forEach((value)=>{
        text+="<option id='"+value["id_panneau_marque"]+"'>"+value["panneau_marque"]+"</option>";
    })
    select.innerHTML=text;
}
function tableau_insertion(data,code){
    if(code===200 || code===201){
        $('#errors').hide();
        let mois=["Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"]
        let tableau=document.getElementById("resultat");
        let text="";
        data.forEach((value)=> {
            text+="<tr>\n"+
                "            <td>"+mois[value["mois_installation"]]+" "+value["an_installation"]+"</td>\n"+
                "            <td>"+value["nb_panneaux"]+"</td>\n"+
                "            <td>"+value["surface"]+"</td>\n"+
                "            <td>"+value["puissance_crete"]+"</td>\n"+
                "            <td>"+value["lat"]+"lat, "+value["lon"]+"lon</td>\n"+
                "            <td><a href=\"detail.html?id="+value["id"]+"\" className=\"btn btn-outline-primary btn-sm\" title=\"Voir le détail\"><i \n"+
                "                className=\"bi bi-search\"></i></a></td>\n"+
                "        </tr>";

        })
        tableau.innerHTML=text;}
    else if(code===444){
        $('#errors').html('<i class="fa fa-exclamation-circle"></i> <strong>Aucune installation avec ces filtres</strong>');
        $('#errors').show();
    }
    else{
        let messages =
            {
                400: 'Requête incorrecte',
                401: 'Authentifiez vous',
                403: 'Accès refusé',
                404: 'Page non trouvée',
                500: 'Erreur interne du serveur',
                503: 'Service indisponible'
            };

//Affiche l'erreur.
        if (code in messages)
        {
            $('#errors').html('<i class="fa fa-exclamation-circle"></i> <strong>' +
                messages[code] + '</strong>');
            $('#errors').show();
        }
    }
}

function recherche() {
    console.log("oui");
    let panneau = $('#panneau').val();
    let onduleur = $('#onduleur').val();
    let departement = $('#departement').val();
    console.log(panneau);
    console.log(onduleur);
    console.log(departement);
    let url="../php/request.php/recherche?id_ond="+onduleur+"&id_pan="+panneau+"&id_dep="+departement;
    ajaxRequest2('GET', url, tableau_insertion)

}

window.addEventListener("DOMContentLoaded",()=>{
    document.getElementById("formulaire").addEventListener("submit",(event)=>{
        event.preventDefault();
        recherche();
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