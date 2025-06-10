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
                case 'modele':
                    //si une marque à commencé à être taper
                    if (isset($data['modele'])) {
                        $result = onduleur::modeleOndFiltre($db, $data['modele']);
                    } else {
                        //sinon 20 marques hazard
                        $result = onduleur::modeleOnd($db);
                    }
                    break;
                default:
                    break;
            }
            break;
        case 'POST':
            if ($demande=="marque" && isset($data['marque'])) {
                if(onduleur::addMarqueOnduleur($db, $data['marque'])) {
                    http_response_code(201);
                    echo json_encode('Marque onduleur bien ajoute');
                    return;
                }
                else{
                    http_response_code(400);
                    echo json_encode('Echec ajout d\'une marque Onduleur');
                    return;
                }
            }
            if ($demande=="modele" && isset($data['modele'])) {
                if(onduleur::addModeleOnduleur($db, $data['modele'])) {
                    http_response_code(201);
                    echo json_encode('Modele onduleur bien ajoute');
                    return;
                }
                else{
                    http_response_code(400);
                    echo json_encode('Echec ajout d\'un modele Onduleur');
                    return;
                }
            }

            break;
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