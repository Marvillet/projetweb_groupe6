'use strict'

// ==== Fonctions d'affichage ====

function nbInstall(data) {
    document.getElementById('nb_install').innerHTML = data
}
function nbInstallateurs(data) {
    document.getElementById('installateur').innerHTML = data
}
function nbPanneau(data) {
    document.getElementById('nb_panneau').innerHTML = data
}
function nbOnduleur(data) {
    document.getElementById('nb_onduleur').innerHTML = data
}
function byYear(data) {
    document.getElementById('byYear').innerHTML = data
}
function byRegion(data) {
    document.getElementById('byRegion').innerHTML = data
}
function byRegionYear(data) {
    document.getElementById('byRegionYear').innerHTML = data
}

// ==== Mises à jour des titres et stats ====

function updateYearStats(annee) {
    ajaxRequest('GET', '../php/request.php/stat/annee?id_an=' + annee, byYear)
    const titleByYear = document.getElementById('titleByYear')
    if (titleByYear) titleByYear.textContent = annee
}

function updateRegionStats(region, region_nom) {
    ajaxRequest('GET', '../php/request.php/stat/region?id_reg=' + region, byRegion)
    const titleByRegion = document.getElementById('titleByRegion')
    if (titleByRegion) titleByRegion.textContent = region_nom
}

function updateRegionYearStats(region, region_nom, annee) {
    ajaxRequest('GET', '../php/request.php/stat/an_reg?id_an=' + annee + '&id_reg=' + region, byRegionYear)
    const titleByRegionYear = document.getElementById('titleByRegionYear')
    if (titleByRegionYear) titleByRegionYear.textContent = region_nom + ' en ' + annee
}

// ==== Remplissage dynamique des <select> + stats associées ====

function recupAnnee(annees) {
    const an = document.getElementById('selectYear')
    an.innerHTML = ''
    annees.forEach(annee => {
        an.innerHTML += `<option value="${annee.annee}">${annee.annee}</option>`
    })

    // Une fois chargé, on initialise les stats par année
    const selectedYear = an.value
    updateYearStats(selectedYear)

    // Si région déjà chargée, on met aussi à jour Region + Année
    const reg = document.getElementById('selectRegion')
    if (reg.options.length > 0) {
        const region = reg.value
        const region_nom = reg.selectedOptions[0].text
        updateRegionYearStats(region, region_nom, selectedYear)
    }
}

function recupReg(regions) {
    const reg = document.getElementById('selectRegion')
    reg.innerHTML = ''
    regions.forEach(region => {
        reg.innerHTML += `<option value="${region.reg_code}">${region.reg_nom}</option>`
    })

    // Une fois chargé, on initialise les stats par région
    const selectedRegion = reg.value
    const region_nom = reg.selectedOptions[0].text
    updateRegionStats(selectedRegion, region_nom)

    // Si année déjà chargée, on met aussi à jour Region + Année
    const an = document.getElementById('selectYear')
    if (an.options.length > 0) {
        const annee = an.value
        updateRegionYearStats(selectedRegion, region_nom, annee)
    }
}

// ==== Initialisation principale ====
document.addEventListener("DOMContentLoaded", function () {
    const currentPage = window.location.pathname.split("/").pop();

    document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });
});

function main() {
    // Statistiques globales
    ajaxRequest('GET', '../php/request.php/stat/total', nbInstall)
    ajaxRequest('GET', '../php/request.php/stat/installateur', nbInstallateurs)
    ajaxRequest('GET', '../php/request.php/stat/panneau', nbPanneau)
    ajaxRequest('GET', '../php/request.php/stat/onduleur', nbOnduleur)

    // Récupération dynamique des années et régions
    ajaxRequest('GET', '../php/request.php/date/annee', recupAnnee)
    ajaxRequest('GET', '../php/request.php/lieu/region', recupReg)

    // Changement d'année
    document.getElementById("selectYear").addEventListener("change", function () {
        const annee = this.value
        updateYearStats(annee)

        const reg = document.getElementById('selectRegion')
        const region = reg.value
        const region_nom = reg.selectedOptions[0].text
        updateRegionYearStats(region, region_nom, annee)
    })

    // Changement de région
    document.getElementById("selectRegion").addEventListener("change", function () {
        const region = this.value
        const region_nom = this.selectedOptions[0].text

        updateRegionStats(region, region_nom)

        const an = document.getElementById('selectYear')
        const annee = an.value
        updateRegionYearStats(region, region_nom, annee)
    })
}

// Lancer une fois le DOM prêt
window.addEventListener("DOMContentLoaded", main)
