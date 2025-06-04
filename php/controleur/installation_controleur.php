<?php
//on récupère le modèle

function GestionDemande($db,$method, $id, $data)
{
    $result=false;
    switch ($method) {
        case 'GET':
            if ($id) {
                //on renvoie les result d'une installation précise
                $result = infosInstall($db,$id);
            }
            break;
        case 'POST':
            /*
            if (isset($_POST['id']) && isset($_POST['comment'])) {
                $result = 'on ajoute la result';
            }
            */
            break;
        case 'DELETE':
            if ($id != NULL) {
                $result = 'on supprime la data d\'id ';
            }
            break;
        case 'PUT':
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