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

function byRegionYear(data){
    let install=document.getElementById('byRegionYear')
    install.innerHTML=data
}

function updateYearStats(annee) {
    ajaxRequest('GET','../php/request.php/stat/annee?id_an=' + annee, byYear)
    // Mise à jour dynamique des titres
    const titleByYear = document.getElementById('titleByYear')
    if (titleByYear) titleByYear.textContent = annee
}
function updateRegionStats(region) {
    ajaxRequest('GET','../php/request.php/stat/annee?id_an=' + region, byRegion)
    // Mise à jour dynamique des titres
    const titleByRegion = document.getElementById('titleByRegion')
    if (titleByRegion) titleByRegion.textContent = region
}

function updateRegionYearStats(region,annee) {
    ajaxRequest('GET','../php/request.php/stat/an_reg?id_an='+annee+'&id_reg=' + region, byRegionYear)
    // Mise à jour dynamique des titres
    const titleByRegionYear = document.getElementById('titleByRegionYear')
    if (titleByRegionYear) titleByRegionYear.textContent = region
}

function main() {
    ajaxRequest('GET','../php/request.php/stat/total',nbInstall)
    ajaxRequest('GET','../php/request.php/stat/installateur',nbInstallateurs)
    ajaxRequest('GET','../php/request.php/stat/panneau',nbPanneau)
    ajaxRequest('GET','../php/request.php/stat/onduleur',nbOnduleur)

    let annee = document.getElementById('selectYear').value
    updateYearStats(annee)
    let region = document.getElementById('selectRegion').value
    updateRegionStats(region)
    updateRegionYearStats(region,annee)
    document.getElementById("selectYear").addEventListener("change", function () {
        let annee = this.value
        updateYearStats(annee)
        updateRegionYearStats(region,annee)
    });
    document.getElementById("selectRegion").addEventListener("change", function () {
        let region = this.value
        updateRegionStats(region)
        updateRegionYearStats(region,annee)
    });

}
window.addEventListener("DOMContentLoaded",main)