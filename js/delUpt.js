'use strict'
window.addEventListener("DOMContentLoaded",main);

function main(){
    console.log("oui");
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