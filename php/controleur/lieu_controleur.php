<?php

require_once 'modele/lieu_modele.php';
function GestionDemande($db, $method, $demande, $data)
{
    $result = false;
    switch ($method) {
        case 'GET':
            switch ($demande) {
                case 'departement':
                    //si une marque à commencé à être taper
                    if (isset($data['dep'])) {
                        $result = lieu::depFiltre($db, $data['dep']);
                    } else {
                        //sinon 20 marques hazard
                        $result = lieu::recupDep($db);
                    }
                    break;
                case 'commune':
                    //si une marque à commencé à être taper
                    if (isset($data['commune'])) {
                        $result = lieu::CommuneFiltre($db, $data['commune']);
                    } else {
                        //sinon 20 marques hazard
                        $result = lieu::recupCommune($db);
                    }
                    break;
                case 'region':
                    $result = lieu::region($db);     // pas de paramètre nécessaire
                    break;
                case 'coord':
                    if (isset($data['dep']) && isset($data['annee'])) {
                        $result = lieu::coord($db, $data['dep'], $data['annee']);
                    }
                    break;
                default:
                    //http_response_code(405);
                    echo json_encode(["error" => "Méthode non autorisee"]);
                    break;
            }
            break;
        //seule la methode Get est autorisé pour les statistiques
        default:
            //http_response_code(405);
            echo json_encode(["error" => "Methode non autorisee"]);
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
        echo json_encode(["error" => "Aucune data valide à renvoyer"]);
    }
}
?>