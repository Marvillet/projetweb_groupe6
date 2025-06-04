<?php
function GestionDemande($db,$method, $demande, $data)
{
    $result=false;
    switch ($method) {
        case 'GET':
            switch ($demande) {
                case 'marque':
                    //si une marque à commencé à être taper
                    if(isset($data['marque'])){
                        $result="bientot les marques commençant par".$data['marque'];
                    }
                    else{
                        //sinon 20 marques hazard
                        $result=marquePan($db);
                    }
                    break;

                default:
                    //http_response_code(405);
                    echo json_encode(["error" => "Méthode non autorisee"]);
                    break;
            }
        //seule la methode Get est autorisé pour les statistiques
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