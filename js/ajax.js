
'use strict';

//------------------------------------------------------------------------------
//--- ajaxRequest --------------------------------------------------------------
//------------------------------------------------------------------------------
// Effectue une requête Ajax.
// \param type Le type de requête (GET, DELETE, POST, PUT).
// \param url L'URL avec les données.
// \param callback La fonction de rappel à appeler lorsque la requête réussit.
// \param data Les données associées à la requête.

function ajaxRequest(method, url, callback) {
  const xhr = new XMLHttpRequest();
  xhr.open(method, url);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        try {
          const response = JSON.parse(xhr.responseText);
          callback(response);
        } catch (e) {
          console.error("Erreur de parsing JSON :", e);
          callback([]); // réponse vide ou corrompue
        }
      } else {
        console.warn(`Requête échouée (${xhr.status}) : ${url}`);
        callback([]); // On appelle quand même avec un tableau vide
      }
    }
  };
  xhr.send();
}


//------------------------------------------------------------------------------
//--- httpErrors ---------------------------------------------------------------
//------------------------------------------------------------------------------
// Affiche un message d'erreur en fonction d'un code d'erreur.
// \param errorCode Le code d'erreur (par exemple un code de statut HTTP).

function httpErrors(errorCode)
{
  let messages =
  {
    400: 'Requête incorrecte',
    401: 'Authentifiez vous',
    403: 'Accès refusé',
    404: 'Page non trouvée',
    500: 'Erreur interne du serveur',
    503: 'Service indisponible'
  };

// Affiche l'erreur.
  /*if (errorCode in messages)
  {
    $('#errors').html('<i class="fa fa-exclamation-circle"></i> <strong>' +
        messages[errorCode] + '</strong>');
    $('#errors').show();
  }*/
}
