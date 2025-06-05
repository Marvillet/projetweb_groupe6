'use strict'

function showInfo(){
    const info = document.getElementById('info');
    if (info.style.display === 'none' || info.style.display === '') {
        info.style.display = 'block';
    } else {
        info.style.display = 'none';
    }
}

function hideInfo() {
    const info = document.getElementById('info');
    info.style.display = 'none';
}

/**
 * Récupère en JSON les installations pour un département + année.
 * @param {string} dep   (ex. "33")
 * @param {string|number} annee (ex. 2024)
 * @returns {Promise<Array<{id:number,lat:number,lon:number}>>}
 */
export async function getCoords(dep, annee) {
  const params = new URLSearchParams({ dep, annee });
  const url    = `/api/lieu_coord.php?${params}`;

  const res = await fetch(url);
  if (!res.ok) throw new Error('API error ' + res.status);
  return res.json();     // Promesse → tableau d’objets
}

/* Exemple d’utilisation : */
getCoords('33', 2024)
  .then(data => console.table(data))   // ou map(data …) pour Leaflet
  .catch(err => console.error(err));