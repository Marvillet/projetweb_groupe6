<?php

//on récupère le modèle
function noDataFound()
{
    header('HTTP/1.1 444 Bad Request');
    echo json_encode(["error" => "Aucune data sur cette installation"]);
    return false;
}
function GestionDemande($db, $method, $gestion, $data)
{
    $result = false;
    switch ($method) {
        case 'GET':
            if($data['id_ond']!='null' && $data['id_pan']!='null' && $data['id_dep']!='null'){

                $result=infosTrois($db,$data['id_dep'],$data['id_pan'],$data['id_ond']);
                if(empty($result)){
                    return noDataFound();
                }
            }
            elseif($data['id_pan']!='null' && $data['id_dep']!='null'){
                $result=infosDepPann($db,$data['id_dep'],$data['id_pan']);
                if(empty($result)){
                    return noDataFound();
                }
            }
            elseif($data['id_ond']!='null' && $data['id_dep']!='null'){
                $result=infosDepOndul($db,$data['id_dep'],$data['id_ond']);
                if(empty($result)){
                    return noDataFound();
                }
            }
            elseif($data['id_ond']!='null' && $data['id_pan']!='null'){
                $result=infosDeuxMarque($db,$data['id_pan'],$data['id_ond']);
                if(empty($result)){
                    return noDataFound();
                }
            }
            elseif($data['id_pan']!='null'){
                $result=installByPanneau($db,$data['id_pan']);
                echo($data['id_pan']);
                if(empty($result)){
                    return noDataFound();
                }
            }
            elseif($data['id_dep']!='null'){
                $result=installByDep($db,$data['id_dep']);
                if(empty($result)){
                    return noDataFound();
                }
            }
            elseif($data['id_ond']!='null'){
                //affiche les 100 premières instalations de la marque d'onduleur
                $result=installByOnduleur($db,$data['id_ond']);
                if(empty($result)){
                    return noDataFound();
                }
            }
            break;
        //seule la methode Get est autorisé pour les statistiques
        default:
            header('HTTP/1.1 400 Method Not Allowed');
            echo json_encode(["error" => "Methode de recherche non autorisee"]);
            return false;
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
        echo json_encode(["error" => "Ressource introuvable"]);
    }
}
