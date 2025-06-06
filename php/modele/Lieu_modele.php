<?php

class lieu
{

    // Departements
    static function recupDep($db){
        $stmt = $db->prepare("Select dep_code,dep_nom from departement order by RAND() LIMIT 20;");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
//Récupère 20 departement de panneau commençant par $text
    static function depFiltre($db,$text){
        $stmt = $db->prepare("
        Select dep_code,dep_nom from departement
        WHERE LOWER(dep_nom) LIKE LOWER(:term) 
        LIMIT 20;
    ");
        $stmt->execute(['term'=>'%'.$text.'%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    //récupération de toutes les régions
    static function region($db){
        $stmt = $db->prepare("
           SELECT reg_code,reg_nom
           FROM region
           ORDER BY Rand()
           LIMIT 20;");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    // Récupération coordonnées pour la carte
    static function coord($db,$dep,$annee){
        $stmt = $db->prepare("
            SELECT lat, lon,id
            FROM installation
            JOIN commune ON installation.code_insee = commune.code_insee
            WHERE an_installation =:annee AND dep_code =:dep;
               ");
        $stmt->execute(['annee'=>$annee,'dep'=>$dep]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;

    }
}