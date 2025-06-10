<?php

class onduleur
{
    // Marque ondulateur
    static function marqueOnd($db){
        $stmt = $db->prepare("
            SELECT id_onduleur_marque,onduleur_marque 
            FROM onduleur_marque om
            ORDER BY RAND()
            LIMIT 20;");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function marqueOndFiltre($db,$text){
        $stmt = $db->prepare("
            SELECT id_onduleur_marque,onduleur_marque FROM onduleur_marque
            WHERE LOWER(onduleur_marque) LIKE LOWER(:term) 
            LIMIT 20;");
        $stmt->execute(['term'=>'%'.$text.'%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    static function modeleOnd($db){
        $stmt = $db->prepare("
            SELECT id_onduleur_modele,onduleur_modele FROM onduleur_modele
            ORDER BY RAND()
            LIMIT 20;");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function modeleOndFiltre($db,$text){
        $stmt = $db->prepare("
            SELECT id_onduleur_modele,onduleur_modele FROM onduleur_modele
            WHERE LOWER(onduleur_modele) LIKE LOWER(:term) 
            LIMIT 20;");
        $stmt->execute(['term'=>'%'.$text.'%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}