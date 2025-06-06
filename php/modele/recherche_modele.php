<?php

class recherche
{
// Installation par marque de panneau
    static function installByPanneau($db,$marque){
        $stmt = $db->prepare("
            SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon 
            FROM installation i
            JOIN panneau p ON p.id_panneau = i.id_panneau
            JOIN panneaux_marque pm ON p.id_panneau_marque = pm.id_panneau_marque
            WHERE pm.id_panneau_marque=CAST(:marque as INT)
            LIMIT 100;");
        $stmt->execute(['marque'=>$marque]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    // Installation par marque de panneau
    static function installByOnduleur($db,$marque){
        $stmt = $db->prepare("
            SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon 
            FROM installation i
            JOIN onduleur p ON p.id_onduleur = i.id_onduleur
            JOIN onduleur_marque pm ON p.id_onduleur_marque = pm.id_onduleur_marque
            WHERE pm.id_onduleur_marque=CAST(:marque as INT)
            LIMIT 100;");
        $stmt->execute(['marque'=>$marque]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    // Installation par departement
    static function installByDep($db,$dep){
        $stmt = $db->prepare("
            SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon
            FROM installation i
            JOIN commune c ON i.code_insee = c.code_insee
            JOIN departement d ON c.dep_code = d.dep_code
            WHERE d.dep_code=CAST(:dep AS INT)
            LIMIT 100;");
        $stmt->execute(['dep'=>$dep]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    static function infosDeuxMarque($db,$panneau,$onduleur){
        $stmt = $db->prepare("
            SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon
            
            FROM installation i
            
            LEFT JOIN installateur inst ON i.id_installateur = inst.id_installateur
            LEFT JOIN commune c ON i.code_insee = c.code_insee
            LEFT JOIN departement d ON c.dep_code = d.dep_code
            LEFT JOIN region r ON d.reg_code = r.reg_code
            LEFT JOIN pays p ON r.id_pays = p.id_pays
            
            LEFT JOIN panneau pnn ON i.id_panneau = pnn.id_panneau
            LEFT JOIN panneaux_modele pm ON pnn.id_panneau_modele = pm.id_panneau_modele
            LEFT JOIN panneaux_marque pmq ON pnn.id_panneau_marque = pmq.id_panneau_marque
            
            LEFT JOIN onduleur ond ON i.id_onduleur = ond.id_onduleur
            LEFT JOIN onduleur_modele om ON ond.id_onduleur_modele = om.id_onduleur_modele
            LEFT JOIN onduleur_marque omq ON ond.id_onduleur_marque = omq.id_onduleur_marque
            
            WHERE pmq.id_panneau_marque =:panneau  AND omq.id_onduleur_marque =:onduleur
            
            LIMIT 100;");
        $stmt->execute(['panneau'=>$panneau,'onduleur'=>$onduleur]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

// Récup info sachant marque de l'onduleur et departement
    static function infosDepOndul($db,$dep,$onduleur){
        $stmt = $db->prepare("
            SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon
            
            FROM installation i
            
            LEFT JOIN installateur inst ON i.id_installateur = inst.id_installateur
            LEFT JOIN commune c ON i.code_insee = c.code_insee
            LEFT JOIN departement d ON c.dep_code = d.dep_code
            LEFT JOIN region r ON d.reg_code = r.reg_code
            LEFT JOIN pays p ON r.id_pays = p.id_pays
            
            LEFT JOIN panneau pnn ON i.id_panneau = pnn.id_panneau
            LEFT JOIN panneaux_modele pm ON pnn.id_panneau_modele = pm.id_panneau_modele
            LEFT JOIN panneaux_marque pmq ON pnn.id_panneau_marque = pmq.id_panneau_marque
            
            LEFT JOIN onduleur ond ON i.id_onduleur = ond.id_onduleur
            LEFT JOIN onduleur_modele om ON ond.id_onduleur_modele = om.id_onduleur_modele
            LEFT JOIN onduleur_marque omq ON ond.id_onduleur_marque = omq.id_onduleur_marque
            
            WHERE d.dep_code =:dep  AND omq.id_onduleur_marque =:onduleur
            
            LIMIT 100;");
        $stmt->execute(['dep'=>$dep,'onduleur'=>$onduleur]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

// Récup info sachant marque du panneau et departement
    static function infosDepPann($db,$dep,$panneau){
        $stmt = $db->prepare("
            SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon
            
            FROM installation i
            
            LEFT JOIN installateur inst ON i.id_installateur = inst.id_installateur
            LEFT JOIN commune c ON i.code_insee = c.code_insee
            LEFT JOIN departement d ON c.dep_code = d.dep_code
            LEFT JOIN region r ON d.reg_code = r.reg_code
            LEFT JOIN pays p ON r.id_pays = p.id_pays
            
            LEFT JOIN panneau pnn ON i.id_panneau = pnn.id_panneau
            LEFT JOIN panneaux_modele pm ON pnn.id_panneau_modele = pm.id_panneau_modele
            LEFT JOIN panneaux_marque pmq ON pnn.id_panneau_marque = pmq.id_panneau_marque
            
            LEFT JOIN onduleur ond ON i.id_onduleur = ond.id_onduleur
            LEFT JOIN onduleur_modele om ON ond.id_onduleur_modele = om.id_onduleur_modele
            LEFT JOIN onduleur_marque omq ON ond.id_onduleur_marque = omq.id_onduleur_marque
            
            WHERE d.dep_code =:dep  AND pmq.id_panneau_marque =:panneau
            
            LIMIT 100;");
        $stmt->execute(['dep'=>$dep,'panneau'=>$panneau]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

// Récup info sachant marque du panneau et de l'onduleur et le departement
    static function infosTrois($db,$dep,$panneau,$onduleur){
        $stmt = $db->prepare("
            SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon
            
            FROM installation i
            
            LEFT JOIN installateur inst ON i.id_installateur = inst.id_installateur
            LEFT JOIN commune c ON i.code_insee = c.code_insee
            LEFT JOIN departement d ON c.dep_code = d.dep_code
            LEFT JOIN region r ON d.reg_code = r.reg_code
            LEFT JOIN pays p ON r.id_pays = p.id_pays
            
            LEFT JOIN panneau pnn ON i.id_panneau = pnn.id_panneau
            LEFT JOIN panneaux_modele pm ON pnn.id_panneau_modele = pm.id_panneau_modele
            LEFT JOIN panneaux_marque pmq ON pnn.id_panneau_marque = pmq.id_panneau_marque
            
            LEFT JOIN onduleur ond ON i.id_onduleur = ond.id_onduleur
            LEFT JOIN onduleur_modele om ON ond.id_onduleur_modele = om.id_onduleur_modele
            LEFT JOIN onduleur_marque omq ON ond.id_onduleur_marque = omq.id_onduleur_marque
            
            WHERE d.dep_code =:dep  AND pmq.id_panneau_marque =:panneau AND omq.id_onduleur_marque =:onduleur
            
            LIMIT 100;");
        $stmt->execute(['dep'=>$dep,'panneau'=>$panneau,'onduleur'=>$onduleur]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }


}