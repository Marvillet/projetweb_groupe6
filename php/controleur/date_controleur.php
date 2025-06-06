<?php
require_once "modele/date_modele.php";
function GestionDemande($db, $method, $demande, $data)
{
    $result = false;
    switch ($method) {
        case 'GET':
            switch ($demande) {
                case 'annee':
                    //si une marque à commencé à être taper
                    $result = date::annee($db);
                    break;
                default:
                    //http_response_code(405);
                    echo json_encode(["error" => "Methode non autorisee"]);
                    return false;
                    break;
            }
            break;
        //seule la methode Get est autorisé pour les statistiques
        default:
            http_response_code(405);
            echo json_encode(["error" => "Methode non autorisee"]);
            break;
            return ;
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
        echo json_encode(["error" => "Aucune data valide à renvoyer"]);
    }
}