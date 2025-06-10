<?php
//on récupère le modèle
require_once "modele/installation_modele.php";
function GestionDemande($db,$method, $id, $data)
{
    $result=false;
    switch ($method) {
        case 'GET':
            if ($id !=NULL) {
                //on renvoie les result d'une installation précise
                $result = installation::infosInstall($db,$id);
            }
            else{
                $result=installation::infosInstalls($db);
            }
            break;
        case 'POST':
            /*
            if (isset($_POST['id']) && isset($_POST['comment'])) {
                $result = 'on ajoute la result';
            }
            */
            installation::insert($db,$data);
            break;
        case 'DELETE':
            if ($id != NULL) {
                if(installation::delete($db,$id)){
                    $result=installation::infosInstallsAdmin($db);
                }
                else{
                    header('HTTP/1.1 403 Bad Request');
                    return;
                }
            }
            break;
        case 'PUT':
            error_log("probleme");
            if ($id != NULL && is_array($data)) { // Check if $data is an array (from JSON)

                if (isset($data['mois_installation']) && isset($data['an_installation'])) {
                    installation::update($db, $id, $data); // Correct order of parameters
                    http_response_code(200); // Success
                    echo json_encode(["message" => "Modification réussie !"]);
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(["error" => "Données manquantes ou incorrectes pour la modification."]);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "ID d'installation manquant ou format de données invalide."]);
            }
            break;
            /*
            if (isset($_PUT['comment']) && $id != NULL) {
                $data = dbModifyComment($db, $login, $id, $_PUT['comment']);
            }
            */
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