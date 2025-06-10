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
    static function addOnduleur($db,$id_onduleur_marque,$id_onduleur_modele){
        $stmt = $db->prepare("INSERT INTO onduleur (id_onduleur_marque, id_onduleur_modele)
                                VALUES ( :id_onduleur_marque,:id_onduleur_modele);");
        $stmt->execute(['id_onduleur_modele'=>$id_onduleur_modele,'id_onduleur_marque'=>$id_onduleur_marque]);
        return $db->lastInsertId();
    }
    //Si le onduleur avec ces id existe renvoie son id
    //sinon ça le crée
    static function findOnduleur($db,$id_onduleur_marque,$id_onduleur_modele)
    {
        $stmt = $db->prepare("
            SELECT id_onduleur FROM onduleur
            WHERE id_onduleur_marque=:id_onduleur_marque AND id_onduleur_modele=:id_onduleur_modele;");
        $stmt->execute(['id_onduleur_marque'=>$id_onduleur_marque,'id_onduleur_modele'=>$id_onduleur_modele]);
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        if($results){
            return $results;
        }
        else{
            return onduleur::addonduleur($db,$id_onduleur_marque,$id_onduleur_modele);
        }
    }
    static function addMarqueOnduleur($db,$marque){
        $stmt = $db->prepare("INSERT INTO onduleur_marque (onduleur_marque)
                                VALUES ( :marque);");
        return $stmt->execute(['marque'=>$marque]);
    }
    static function addModeleOnduleur($db,$modele)
    {
        $stmt = $db->prepare("INSERT INTO onduleur_modele (onduleur_modele) VALUES ( :modele);");
        $stmt->execute(['modele'=>$modele]);
    }
}