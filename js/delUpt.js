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

function installdelete(event){
    console.log("delete");
    let id=event.target.dataset.id;
    ajaxRequest('DELETE','../php/request.php/admin/'+id,addlignes)
}