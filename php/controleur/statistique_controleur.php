<?php
require_once "modele/statistique_modele.php";
function GestionDemande($db,$method, $stat, $data)
{
    $result=false;
    switch ($method) {
        case 'GET':
            //switch en fct de la stat demandé
            switch ($stat) {
                case 'region':
                    if(isset($data['id_reg'])){
                        $result=statistique::installByRegion($db,$data['id_reg']);
                    }
                    break;
                case 'total':
                    $result=statistique::countInstal($db);
                    break;
                case 'annee':
                    if(isset($data['id_an'])){
                        $result=statistique::installByYear($db,$data['id_an']);
                    }
                    break;
                case 'an_reg':
                    if(isset($data['id_reg']) && isset($data['id_an'])){
                        $result=statistique::installYearRegion($db, $data['id_an'], $data['id_reg']);
                    }
                    break;
                case 'installateur':
                    $result=statistique::nbInstallateurs($db);
                    break;
                case 'onduleur':
                    $result=statistique::nbMarqueOnd($db);
                    break;
                case 'panneau':
                    $result=statistique::nbMarquePan($db);
                    break;
                default:
                    $result="stat demande n'esxiste pas ou pas de stat demandee";
            }
            break;
        //seule la methode Get est autorisé pour les statistiques
        default:
            //http_response_code(405);
            echo json_encode(["error" => "Méthode non autorisee"]);
    }
    if($result!=false){
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
