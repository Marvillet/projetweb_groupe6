<?php


require_once 'modele/installateur_modele.php';
function GestionDemande($db, $method, $id, $data)
{
    $result = false;
    switch ($method) {
        case 'GET':
            if($id!=null){
                $result='pas besoin pour l instant';
            }
            else{
                if(isset($data["filtre"])){

                    $result=installateur::installateurFiltre($db,$data["filtre"]);
                }
                else{
                    $result=installateur::installateurs($db);
                }
            }
            break;
        case 'POST':
            error_log("Installateur");
            if(isset($data["installateur"])){
                if(installateur::addinstallateurs($db,$data["installateur"])){

                    http_response_code(201);
                    echo json_encode('Installateur bien ajoute');
                    return;
                }
            }
            else{
                http_response_code(400);
                echo json_encode('Echec ajout d\'un installateur');
                return;
            }
            break;
        default:
            http_response_code(405);
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
