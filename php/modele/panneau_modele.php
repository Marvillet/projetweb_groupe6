<?php

class panneau
{
    // Marque panneau
    static function marquePan($db){
        $stmt = $db->prepare("SELECT id_panneau_marque,panneau_marque FROM panneaux_marque ORDER BY RAND() LIMIT 20;");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
//Récupère 20 marques de panneau commençant par $text
    static function marquePanFiltre($db,$text){
        $stmt = $db->prepare("
        SELECT id_panneau_marque,panneau_marque FROM panneaux_marque 
        WHERE LOWER(panneau_marque) LIKE LOWER(:term) 
        LIMIT 20;
    ");
        $stmt->execute(['term'=>'%'.$text.'%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}