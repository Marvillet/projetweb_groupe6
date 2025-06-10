<?php
require_once "modele/panneau_modele.php";
function GestionDemande($db,$method, $demande, $data)
{
    $result=false;
    switch ($method) {
        case 'GET':
            switch ($demande) {
                case 'marque':
                    //si une marque à commencé à être taper
                    if(isset($data['marque'])){
                        $result=panneau::marquePanFiltre($db,$data['marque']);
                    }
                    else{
                        //sinon 20 marques hazard
                        $result=panneau::marquePan($db);
                    }
                    break;
                case 'modele':
                    //si une marque à commencé à être taper
                    if(isset($data['modele'])){
                        $result=panneau::modeleFiltre($db,$data['modele']);
                    }
                    else{
                        //sinon 20 marques hazard
                        $result=panneau::modelePan($db);
                    }
                    break;

                default:
                    //http_response_code(405);
                    echo json_encode(["error" => "Méthode non autorisee"]);
                    break;
            }
            break;
        case 'POST':
            if ($demande=="marque" && isset($data['marque'])) {
                if(panneau::addMarquePanneau($db, $data['marque'])) {
                    http_response_code(201);
                    echo json_encode('Marque Panneau bien ajoute');
                    return;
                }
                else{
                    http_response_code(400);
                    echo json_encode('Echec ajout d\'une marque Panneau');
                    return;
                }
            }
            if ($demande=="modele" && isset($data['modele'])) {
                if(panneau::addModelePanneau($db, $data['modele'])) {
                    http_response_code(201);
                    echo json_encode('Modele panneau bien ajoute');
                    return;
                }
                else{
                    http_response_code(400);
                    echo json_encode('Echec ajout d\'un modele panneau');
                    return;
                }
            }
            break;
        default:
            //http_response_code(405);
            echo json_encode(["error" => "Méthode non autorisee"]);
    }
    if($result !=false){
        // Envoie des données au client
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('HTTP/1.1 200 OK');
        echo json_encode($result);
    }
    else{
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(["error" => "Statistique demandee non valide"]);
    }
}