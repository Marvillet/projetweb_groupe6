<?php
//on récupère le modèle
require_once "modele/installation_modele.php";
require_once "modele/onduleur_modele.php";
require_once "modele/panneau_modele.php";
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
                $result=installation::infosInstallsAdmin($db);
            }
            break;
        case 'POST':
            if (isset($data['mois_installation']) &&
                isset($data['an_installation']) &&
                isset($data['nb_panneaux']) &&
                isset($data['surface']) &&
                isset($data['puissance_crete']) &&
                isset($data['orientation']) &&
                isset($data['lat']) &&
                isset($data['lon']) &&
                isset($data['code_insee']) &&
                isset($data['id_panneau_marque']) &&
                isset($data['id_panneau_modele']) &&
                isset($data['id_onduleur_marque']) &&
                isset($data['id_onduleur_modele']) &&
                isset($data['id_installateur']) &&
                isset($data['nb_onduleur']) &&
                isset($data['pente']) &&
                isset($data['puissance_pvgis']) &&
                isset($data['pente_optimum']) &&
                isset($data['orientation_optimum'])) {
                    $id_panneau = panneau::findPanneau($db, $data['id_panneau_marque'], $data['id_panneau_modele']);
                    $id_onduleur = onduleur::findOnduleur($db, $data['id_onduleur_marque'], $data['id_onduleur_modele']);
                    installation::insert($db, $data, $id_panneau, $id_onduleur);
                    http_response_code(201);
                    $result="Ajout des datas Valider";
            }
            else{
                error_log("Tentative POST mais toutes les datas ne sont pas défini");
                error_log(print_r($data,true));
            }
            break;
        case 'DELETE':
            if ($id != NULL) {
                if(installation::delete($db,$id)){
                    $result=installation::infosInstallsAdmin($db);
                }
                error_log("Tentative de suppression de l'id : $id");
            }
            break;
        case 'PUT':
            parse_str(file_get_contents('php://input'), $_PUT);
            error_log("Données reçues pour PUT: " . print_r($data, true));
            if ($id != NULL && is_array($data)) {
                if (isset($data['mois_installation']) && isset($data['an_installation'])) {
                    error_log("Tentative de mise à jour de l'installation $id");
                    $result = installation::update($db, $id, $data);
                    if ($result) {
                        http_response_code(200);
                        echo json_encode(["message" => "Modification réussie !"]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["error" => "Échec de la mise à jour"]);
                    }
                }
                else {
                    http_response_code(400); // Bad Request
                    echo json_encode(["error" => "ID d'installation manquant ou format de données invalide."]);
                }
            }
            break;
            /*
            if (isset($_PUT['comment']) && $id != NULL) {
                $data = dbModifyComment($db, $login, $id, $_PUT['comment']);
            }
            */
        default:
            http_response_code(405);
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