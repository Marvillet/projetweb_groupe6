<?php


function GestionDemande($db, $method, $demande, $data)
{
    $result = false;
    switch ($method) {
        case 'GET':
            switch ($demande) {
                case 'departement':
                    //si une marque à commencé à être taper
                    if (isset($data['dep'])) {
                        $result = depFiltre($db, $data['dep']);
                    } else {
                        //sinon 20 marques hazard
                        $result = recupDep($db);
                    }
                    break;
                case 'region':
                    $result = region($db);     // pas de paramètre nécessaire
                    break;
                case 'coord':
                    if (isset($data['dep']) && isset($data['annee'])) {
                        $result = coord($db, $data['dep'], $data['annee']);
                    }
                    break;
                default:
                    //http_response_code(405);
                    echo json_encode(["error" => "Méthode non autorisee"]);
                    break;
            }
            break;
        //seule la methode Get est autorisé pour les statistiques
        default:
            //http_response_code(405);
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

// public/api/lieu_coord.php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';   // ton fichier de connexion PDO

if (empty($_GET['annee']) || empty($_GET['dep'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Paramètres manquants']);
    exit;
}

$pdo = getPDO();   // fonction helper dans database.php

$sql = "
  SELECT i.id, i.lat, i.lon
  FROM   installation i
  JOIN   commune      c ON c.code_insee = i.code_insee
  JOIN   departement  d ON d.dep_code   = c.dep_code
  WHERE  i.an_installation = :annee
    AND  d.dep_code        = :dep
  LIMIT  1000
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':annee' => (int) $_GET['annee'],
    ':dep' => $_GET['dep']
]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));


?>