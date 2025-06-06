<?php

class statistique
{
    // Nombre enregistrement en base
    static function countInstal($db){
        $stmt = $db->prepare("SELECT COUNT(*) AS total_installations FROM installation");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_installations'];
    }

    // Nombre d'installations par années
    static function installByYear($db, $year){
        $sql = "SELECT COUNT(*) AS total 
        FROM installation 
        WHERE an_installation=:annee;";
        $stmt=$db->prepare($sql);
        $stmt->execute(['annee'=>$year]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results[0]['total'];
    }

    // Nombre d'installations par région
    static function installByRegion($db, $region){
        $stmt = $db->prepare("
            SELECT COUNT(*) AS total 
            FROM installation i
            JOIN commune c ON i.code_insee = c.code_insee
            JOIN departement d ON c.dep_code = d.dep_code
            JOIN region r ON d.reg_code = r.reg_code
            WHERE r.reg_code=:region; ");
        $stmt->execute(['region'=>$region]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results[0]['total'];
    }
    // Nombre d'installations par années et région
    static function installYearRegion($db, $year, $region){
        $stmt = $db->prepare("
            SELECT i.an_installation, r.reg_nom, COUNT(*) AS total 
            FROM installation i
            JOIN commune c ON i.code_insee = c.code_insee
            JOIN departement d ON c.dep_code = d.dep_code
            JOIN region r ON d.reg_code = r.reg_code
            WHERE r.reg_code=:region AND i.an_installation=:year ; ");
        $stmt->execute(['region'=>$region, 'year'=>$year]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results[0]['total'];
    }
    // Nombre d'installateurs
    static function nbInstallateurs($db){
        $stmt = $db->prepare("SELECT COUNT(*) AS total_installateurs FROM installateur");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_installateurs'];
    }
    // Nombre de marques d'onduleurs
    static function nbMarqueOnd($db){
        $stmt = $db->prepare("SELECT COUNT(*) AS nb_marque_onduleur FROM onduleur_marque");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nb_marque_onduleur'];
    }

    // Nombre de marques de panneaux solaires
    static function nbMarquePan($db){
        $stmt = $db->prepare("SELECT COUNT(*) AS nb_marque_panneau FROM panneaux_marque");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nb_marque_panneau'];
    }
    // Installation par marque d'onduleur
    function installByOnduleur($db,$marque){
        $stmt = $db->prepare("
            SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon 
            FROM installation i
            JOIN onduleur o ON o.id_onduleur = i.id_onduleur
            JOIN onduleur_marque om ON o.id_onduleur_marque = om.id_onduleur_marque
            WHERE om.id_onduleur_marque=:marque
            LIMIT 100;");
        $stmt->execute(['marque'=>$marque]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

}