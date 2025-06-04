'use strict'

function displayInfo(data){
    let chambre=document.getElementById('nb_install')
    data.forEach(lst=>{chambre.innerHTML+=data})
}

function main(){
    ajaxRequest('GET','../php/request.php/stat/total',displayInfo)
}
window.addEventListener("DOMContentLoaded",main)