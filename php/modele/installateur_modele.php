<?php

class installateur
{
    // Departements
    static function installateurs($db){
        $stmt = $db->prepare("select id_installateur,installateur.installateur as installateurs from installateur ORDER BY RAND() limit 20 ;");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
//Récupère 20 departement de panneau commençant par $text
    static function installateurFiltre($db,$text){
        //installateurs car installateur mot clés js pour empecher bug
        $stmt = $db->prepare("
         SELECT id_installateur,installateur.installateur as installateurs
         FROM installateur 
         WHERE LOWER(installateur.installateur) LIKE LOWER(:term) LIMIT 20 ;
    ");
        $stmt->execute(['term'=>'%'.$text.'%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    static function addinstallateurs($db,$installateurs){
        $stmt = $db->prepare("
            INSERT INTO installateur(installateur)
            VALUES (:installateur);");
        return $stmt->execute(['installateur'=>$installateurs]);
    }
}