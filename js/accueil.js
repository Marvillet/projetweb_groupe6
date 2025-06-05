'use strict'

function nbInstall(data){
    let install=document.getElementById('nb_install')
     install.innerHTML=data
}
function nbInstallateurs(data){
    let install=document.getElementById('installateur')
    install.innerHTML=data
}
function nbPanneau(data){
    let install=document.getElementById('nb_panneau')
    install.innerHTML=data
}
function nbOnduleur(data){
    let install=document.getElementById('nb_onduleur')
    install.innerHTML=data
}
function byYear(data){
    let install=document.getElementById('byYear')
    install.innerHTML=data
}
function byRegion(data){
    let install=document.getElementById('byRegion')
    install.innerHTML=data
}


function main(){
    ajaxRequest('GET','../php/request.php/stat/total',nbInstall)
    ajaxRequest('GET','../php/request.php/stat/installateur',nbInstallateurs)
    ajaxRequest('GET','../php/request.php/stat/panneau',nbPanneau)
    ajaxRequest('GET','../php/request.php/stat/onduleur',nbOnduleur)
    let annee=document.getElementById('selectYear').value
    ajaxRequest('GET','../php/request.php/stat/annee?id_an='+annee,byYear)
    document.getElementById("selectYear").addEventListener("change", function () {
        let annee=document.getElementById('selectYear').value
        ajaxRequest('GET','../php/request.php/stat/annee?id_an='+annee,byYear)
    });
}
window.addEventListener("DOMContentLoaded",main)