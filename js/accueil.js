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
function updateRegionStats(region,region_nom) {
    ajaxRequest('GET','../php/request.php/stat/region?id_reg=' + region, byRegion)
    // Mise à jour dynamique des titres
    const titleByRegion = document.getElementById('titleByRegion')
    if (titleByRegion) titleByRegion.textContent = region_nom
}

function updateRegionYearStats(region,region_nom,annee) {
    ajaxRequest('GET','../php/request.php/stat/an_reg?id_an='+annee+'&id_reg=' + region, byRegionYear)
    // Mise à jour dynamique des titres
    const titleByRegionYear = document.getElementById('titleByRegionYear')
    if (titleByRegionYear) titleByRegionYear.textContent = region_nom+' en '+annee
}

function recupAnnee(annnes){
    let an=document.getElementById('selectRegion')
    annees.forEach(annee=>{an.innerHTML+='<option value='+annee.annee+'>'+annee.annee+'</option>'})
}

function main() {
    ajaxRequest('GET','../php/request.php/stat/total',nbInstall)
    ajaxRequest('GET','../php/request.php/stat/installateur',nbInstallateurs)
    ajaxRequest('GET','../php/request.php/stat/panneau',nbPanneau)
    ajaxRequest('GET','../php/request.php/stat/onduleur',nbOnduleur)
    ajaxRequest('GET','../php/request.php/date/annee',recupAnnee)

    let annee = document.getElementById('selectYear').value
    updateYearStats(annee)
    let region = document.getElementById('selectRegion').value
    let region_nom=document.getElementById('selectRegion').options[document.getElementById('selectRegion').selectedIndex].text
    updateRegionStats(region,region_nom)
    updateRegionYearStats(region,region_nom,annee)
    document.getElementById("selectYear").addEventListener("change", function () {
        let annee = this.value
        let region_nom=document.getElementById('selectRegion').options[document.getElementById('selectRegion').selectedIndex].text
        updateYearStats(annee)
        updateRegionYearStats(region,region_nom,annee)
    });
    document.getElementById("selectRegion").addEventListener("change", function () {
        let region = this.value
        let region_nom=this.options[this.selectedIndex].text
        updateRegionStats(region,region_nom)
        updateRegionYearStats(region,region_nom,annee)
    });

}
window.addEventListener("DOMContentLoaded",main)