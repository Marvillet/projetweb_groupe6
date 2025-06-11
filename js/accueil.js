'use strict'

/**
 * @function nbInstall
 * @brief Affiche le nombre total d'installations.
 * @param data - Donnée contenant le nombre à afficher.
 */
function nbInstall(data) {
    document.getElementById('nb_install').innerHTML = data;
}

/**
 * @function nbInstallateurs
 * @brief Affiche le nombre d’installateurs.
 * @param {string} data - Donnée contenant le nombre à afficher.
 */
function nbInstallateurs(data) {
    document.getElementById('installateur').innerHTML = data;
}

/**
 * @function nbPanneau
 * @brief Affiche le nombre de panneaux solaires.
 * @param data - Donnée contenant le nombre à afficher.
 */
function nbPanneau(data) {
    document.getElementById('nb_panneau').innerHTML = data;
}

/**
 * @function nbOnduleur
 * @brief Affiche le nombre d’onduleurs.
 * @param data - Donnée contenant le nombre à afficher.
 */
function nbOnduleur(data) {
    document.getElementById('nb_onduleur').innerHTML = data;
}

/**
 * @function byYear
 * @brief Affiche les statistiques filtrées par année.
 * @param {string} data - Données HTML à afficher.
 */
function byYear(data) {
    document.getElementById('byYear').innerHTML = data;
}

/**
 * @function byRegion
 * @brief Affiche les statistiques filtrées par région.
 * @param {string} data - Données HTML à afficher.
 */
function byRegion(data) {
    document.getElementById('byRegion').innerHTML = data;
}

/**
 * @function byRegionYear
 * @brief Affiche les statistiques combinées par région et année.
 * @param {string} data - Données HTML à afficher.
 */
function byRegionYear(data) {
    document.getElementById('byRegionYear').innerHTML = data;
}

/**
 * @function updateYearStats
 * @brief Met à jour les statistiques et le titre pour une année donnée.
 * @param {string} annee - Année sélectionnée.
 */
function updateYearStats(annee) {
    ajaxRequest('GET', '../php/request.php/stat/annee?id_an=' + annee, byYear);
    const titleByYear = document.getElementById('titleByYear');
    if (titleByYear) titleByYear.textContent = annee;
}

/**
 * @function updateRegionStats
 * @brief Met à jour les statistiques et le titre pour une région donnée.
 * @param {string} region - Code de la région.
 * @param {string} region_nom - Nom de la région à afficher.
 */
function updateRegionStats(region, region_nom) {
    ajaxRequest('GET', '../php/request.php/stat/region?id_reg=' + region, byRegion);
    const titleByRegion = document.getElementById('titleByRegion');
    if (titleByRegion) titleByRegion.textContent = region_nom;
}

/**
 * @function updateRegionYearStats
 * @brief Met à jour les statistiques combinées pour une région et une année données.
 * @param {string} region - Code de la région.
 * @param {string} region_nom - Nom de la région.
 * @param {string} annee - Année sélectionnée.
 */
function updateRegionYearStats(region, region_nom, annee) {
    ajaxRequest('GET', '../php/request.php/stat/an_reg?id_an=' + annee + '&id_reg=' + region, byRegionYear);
    const titleByRegionYear = document.getElementById('titleByRegionYear');
    if (titleByRegionYear) titleByRegionYear.textContent = region_nom + ' en ' + annee;
}

/**
 * @function recupAnnee
 * @brief Remplit dynamiquement le menu déroulant des années et met à jour les statistiques.
 * @param {Array<Object>} annees - Liste des années à insérer dans le <select>.
 */
function recupAnnee(annees) {
    const an = document.getElementById('selectYear');
    an.innerHTML = '';
    annees.forEach(annee => {
        an.innerHTML += `<option value="${annee.annee}">${annee.annee}</option>`;
    });

    const selectedYear = an.value;
    updateYearStats(selectedYear);

    const reg = document.getElementById('selectRegion');
    if (reg.options.length > 0) {
        const region = reg.value;
        const region_nom = reg.selectedOptions[0].text;
        updateRegionYearStats(region, region_nom, selectedYear);
    }
}

/**
 * @function recupReg
 * @brief Remplit dynamiquement le menu déroulant des régions et met à jour les statistiques.
 * @param {Array<Object>} regions - Liste des régions à insérer dans le <select>.
 */
function recupReg(regions) {
    const reg = document.getElementById('selectRegion');
    reg.innerHTML = '';
    regions.forEach(region => {
        reg.innerHTML += `<option value="${region.reg_code}">${region.reg_nom}</option>`;
    });

    const selectedRegion = reg.value;
    const region_nom = reg.selectedOptions[0].text;
    updateRegionStats(selectedRegion, region_nom);

    const an = document.getElementById('selectYear');
    if (an.options.length > 0) {
        const annee = an.value;
        updateRegionYearStats(selectedRegion, region_nom, annee);
    }
}

/**
 * @function main
 * @brief Fonction principale appelée au chargement du DOM. Initialise les données et les événements.
 */
function main() {
    const currentPage = window.location.pathname.split("/").pop();

    document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });

    ajaxRequest('GET', '../php/request.php/stat/total', nbInstall);
    ajaxRequest('GET', '../php/request.php/stat/installateur', nbInstallateurs);
    ajaxRequest('GET', '../php/request.php/stat/panneau', nbPanneau);
    ajaxRequest('GET', '../php/request.php/stat/onduleur', nbOnduleur);

    ajaxRequest('GET', '../php/request.php/date/annee', recupAnnee);
    ajaxRequest('GET', '../php/request.php/lieu/region', recupReg);

    document.getElementById("selectYear").addEventListener("change", function () {
        const annee = this.value;
        updateYearStats(annee);

        const reg = document.getElementById('selectRegion');
        const region = reg.value;
        const region_nom = reg.selectedOptions[0].text;
        updateRegionYearStats(region, region_nom, annee);
    });

    document.getElementById("selectRegion").addEventListener("change", function () {
        const region = this.value;
        const region_nom = this.selectedOptions[0].text;

        updateRegionStats(region, region_nom);

        const an = document.getElementById('selectYear');
        const annee = an.value;
        updateRegionYearStats(region, region_nom, annee);
    });
}

/**
 * @brief Initialise l'application une fois que le DOM est complètement chargé.
 */
window.addEventListener("DOMContentLoaded", main);
