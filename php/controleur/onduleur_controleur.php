<?php
require_once "modele/onduleur_modele.php";
function GestionDemande($db, $method, $demande, $data)
{
    $result = false;
    switch ($method) {
        case 'GET':
            switch ($demande) {
                case 'marque':
                    //si une marque à commencé à être taper
                    if (isset($data['marque'])) {
                        $result = onduleur::marqueOndFiltre($db, $data['marque']);
                    } else {
                        //sinon 20 marques hazard
                        $result = onduleur::marqueOnd($db);
                    }
                    break;
            }
            break;
        //seule la methode Get est autorisé pour les statistiques
        default:
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(["error" => "Méthode non autorisee"]);
            return;
            break;
    }
    if ($result != false) {
        // Envoie des données au client
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('HTTP/1.1 200 OK');
        echo json_encode($result);
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(["error" => "Demande invalide"]);
    }
    return;
}