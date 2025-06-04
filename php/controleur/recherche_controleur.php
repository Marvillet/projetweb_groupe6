<?php

//on récupère le modèle

function GestionDemande($db, $method, $gestion, $data)
{
    $result = false;
    switch ($method) {
        case 'GET':
            if(!empty($data['id_ond']) && !empty($data['id_pan']) && !empty($data['id_dep'])){
                $result=infosTrois($db,$data['id_dep'],$data['id_pan'],$data['id_ond']);
            }
            elseif(!empty($data['id_pan']) && !empty($data['id_dep'])){
                $result=infosDepPann($db,$data['id_dep'],$data['id_pan']);
            }
            elseif(!empty($data['id_ond']) && !empty($data['id_dep'])){
                $result=infosDepOndul($db,$data['id_dep'],$data['id_ond']);
            }
            elseif(!empty($data['id_ond']) && !empty($data['id_pan'])){
                $result=infosDeuxMarque($db,$data['id_pan'],$data['id_ond']);
            }
            elseif(!empty($data['id_pan'])){
                $result='soon';
            }
            elseif(!empty($data['id_dep'])){
                $result='soon';
            }
            elseif(!empty($data['id_ond'])){
                //affiche les 100 premières instalations de la marque
                $result=installByPanneau($db,$data['id_ond']);
            }
            break;
        //seule la methode Get est autorisé pour les statistiques
        default:
            //http_response_code(405);
            echo json_encode(["error" => "Méthode non autorisee"]);
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
        echo json_encode(["error" => "Statistique demandee non valide"]);
    }
}
