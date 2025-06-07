'use strict'
window.addEventListener("DOMContentLoaded",main);

function main(){
    $('#installateur-name').select2({
        //Z index à mettre par dessus le modal pour pouvoir voir les options
        dropdownParent: $('#installationModal'),
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
}
function installupdate(event){
    console.log(event.target.dataset.id);
    console.log("update");
    //id de l'installation
    let id=event.target.dataset.id;

}

function installdelete(event) {
    console.log("delete");

    //si l'utilisateur clique sur l'icone, event est alors l'icone elle même et ne possède donc pas d'id
    const button = event.target.closest('button');
    if (!button) return;

    const id = button.dataset.id;
    console.log("ID supprimé :", id);

    ajaxRequest('DELETE', '../php/request.php/admin/' + id, addlignes);
}