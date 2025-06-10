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
    // Marque panneau
    static function modelePan($db){
        $stmt = $db->prepare("SELECT id_panneau_modele,panneau_modele FROM panneaux_modele ORDER BY RAND() LIMIT 20;");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
//Récupère 20 marques de panneau commençant par $text
    static function modeleFiltre($db,$text){
        $stmt = $db->prepare("
        SELECT id_panneau_modele,panneau_modele FROM panneaux_modele
        WHERE LOWER(panneau_modele) LIKE LOWER(:term) 
        LIMIT 20;
    ");
        $stmt->execute(['term'=>'%'.$text.'%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    static function addPanneau($db,$id_panneau_marque,$id_panneau_modele){
        $stmt = $db->prepare("INSERT INTO panneau (id_panneau_modele, id_panneau_marque)
                                VALUES (:id_panneau_modele, :id_panneau_marque);");
        $stmt->execute(['id_panneau_marque'=>$id_panneau_marque,'id_panneau_modele'=>$id_panneau_modele]);
        return $db->lastInsertId();
    }
    //Si le panneau avec ces id existe renvoie son id
    //sinon ça le crée
    static function findPanneau($db,$id_panneau_marque,$id_panneau_modele)
    {
        $stmt = $db->prepare("
            SELECT id_panneau FROM panneau
            WHERE id_panneau_marque=:id_panneau_marque AND id_panneau_modele=:id_panneau_modele;");
        $stmt->execute(['id_panneau_marque'=>$id_panneau_marque,'id_panneau_modele'=>$id_panneau_modele]);
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        if($results){
            return $results;
        }
        else{
            return panneau::addPanneau($db,$id_panneau_marque,$id_panneau_modele);
        }
    }
}