'use strict'

function nbInstall(data){
    let install=document.getElementById('nb_install')
     install.innerHTML+=data
}
function nbInstallateurs(data){
    let install=document.getElementById('installateur')
    install.innerHTML+=data
}
function byYear(data){
    let install=document.getElementById('byYear')
    install.innerHTML+=data
}

function main(){
    ajaxRequest('GET','../php/request.php/stat/total',nbInstall)
    ajaxRequest('GET','../php/request.php/stat/installateur',nbInstallateurs)
}
window.addEventListener("DOMContentLoaded",main)