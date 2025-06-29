<?php

class installation
{
    // Récupération infos d'une installation précise
    static function infosInstall($db,$id){
        $stmt = $db->prepare("
                SELECT 
                i.*,
                inst.installateur,
                c.nom_standard AS commune,
                c.code_postal,
                c.nom_standard,
                c.population,
                d.dep_nom AS departement,
                r.reg_nom AS region,
                p.country AS pays,
                pm.panneau_modele,
                pmq.panneau_marque,
                om.onduleur_modele,
                omq.onduleur_marque,
                pnn.id_panneau_marque,
                pnn.id_panneau_modele,
                ond.id_onduleur_marque,
                ond.id_onduleur_modele
            
            FROM installation i
            
            -- Jointure avec l’installateur
            LEFT JOIN installateur inst ON i.id_installateur = inst.id_installateur
            
            -- Jointure avec la commune
            LEFT JOIN commune c ON i.code_insee = c.code_insee
            
            -- Jointure avec le département et la région
            LEFT JOIN departement d ON c.dep_code = d.dep_code
            LEFT JOIN region r ON d.reg_code = r.reg_code
            LEFT JOIN pays p ON r.id_pays = p.id_pays
            
            -- Jointure avec le panneau
            LEFT JOIN panneau pnn ON i.id_panneau = pnn.id_panneau
            LEFT JOIN panneaux_modele pm ON pnn.id_panneau_modele = pm.id_panneau_modele
            LEFT JOIN panneaux_marque pmq ON pnn.id_panneau_marque = pmq.id_panneau_marque
            
            -- Jointure avec l’onduleur
            LEFT JOIN onduleur ond ON i.id_onduleur = ond.id_onduleur
            LEFT JOIN onduleur_modele om ON ond.id_onduleur_modele = om.id_onduleur_modele
            LEFT JOIN onduleur_marque omq ON ond.id_onduleur_marque = omq.id_onduleur_marque 
            
            WHERE i.id=:id;");
        $stmt->execute(['id'=>$id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

// Récupération infos de toutes les installations
    static function infosInstalls($db){
        $stmt = $db->prepare("
            SELECT id,c.nom_standard,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon
            
            FROM installation i
            
            -- Jointure avec l’installateur
            LEFT JOIN installateur inst ON i.id_installateur = inst.id_installateur
            
            -- Jointure avec la commune
            LEFT JOIN commune c ON i.code_insee = c.code_insee
            
            -- Jointure avec le département et la région
            LEFT JOIN departement d ON c.dep_code = d.dep_code
            LEFT JOIN region r ON d.reg_code = r.reg_code
            LEFT JOIN pays p ON r.id_pays = p.id_pays
            
            -- Jointure avec le panneau
            LEFT JOIN panneau pnn ON i.id_panneau = pnn.id_panneau
            LEFT JOIN panneaux_modele pm ON pnn.id_panneau_modele = pm.id_panneau_modele
            LEFT JOIN panneaux_marque pmq ON pnn.id_panneau_marque = pmq.id_panneau_marque
            
            -- Jointure avec l’onduleur
            LEFT JOIN onduleur ond ON i.id_onduleur = ond.id_onduleur
            LEFT JOIN onduleur_modele om ON ond.id_onduleur_modele = om.id_onduleur_modele
            LEFT JOIN onduleur_marque omq ON ond.id_onduleur_marque = omq.id_onduleur_marque
            ORDER BY RAND()
            LIMIT 100;");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // Récupération infos des 100 dernières installations chronologiquement
    static function infosInstallsAdmin($db){
        $stmt = $db->prepare("
            SELECT id,c.nom_standard,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon
            
            FROM installation i
            
            -- Jointure avec l’installateur
            LEFT JOIN installateur inst ON i.id_installateur = inst.id_installateur
            
            -- Jointure avec la commune
            LEFT JOIN commune c ON i.code_insee = c.code_insee
            
            -- Jointure avec le département et la région
            LEFT JOIN departement d ON c.dep_code = d.dep_code
            LEFT JOIN region r ON d.reg_code = r.reg_code
            LEFT JOIN pays p ON r.id_pays = p.id_pays
            
            -- Jointure avec le panneau
            LEFT JOIN panneau pnn ON i.id_panneau = pnn.id_panneau
            LEFT JOIN panneaux_modele pm ON pnn.id_panneau_modele = pm.id_panneau_modele
            LEFT JOIN panneaux_marque pmq ON pnn.id_panneau_marque = pmq.id_panneau_marque
            
            -- Jointure avec l’onduleur
            LEFT JOIN onduleur ond ON i.id_onduleur = ond.id_onduleur
            LEFT JOIN onduleur_modele om ON ond.id_onduleur_modele = om.id_onduleur_modele
            LEFT JOIN onduleur_marque omq ON ond.id_onduleur_marque = omq.id_onduleur_marque
            ORDER BY an_installation DESC ,mois_installation DESC
            LIMIT 100;");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }


// Insertion d'installation
    static function insert($db,$data,$id_panneau,$id_onduleur){
        $stmt = $db->prepare("INSERT INTO installation (mois_installation, an_installation, nb_panneaux, surface, puissance_crete, orientation, lat, lon,
                                code_insee, id_panneau, id_onduleur, id_installateur, nb_onduleur, pente, puissance_pvgis,
                                pente_optimum, orientation_optimum)
                                VALUES (:mois_installation, :an_installation, :nb_panneaux, :surface, :puissance_crete, :orientation, :lat, :lon,
                                :code_insee, :id_panneau, :id_onduleur, :id_installateur, :nb_onduleur, :pente, :puissance_pvgis,
                                :pente_optimum, :orientation_optimum);");
        $bool=$stmt->execute([
            'mois_installation' => $data['mois_installation'],
            'an_installation' => $data['an_installation'],
            'nb_panneaux' => $data['nb_panneaux'],
            'surface' => $data['surface'],
            'puissance_crete' => $data['puissance_crete'],
            'orientation' => $data['orientation'],
            'lat' => $data['lat'],
            'lon' => $data['lon'],
            'code_insee' => $data['code_insee'],
            'id_panneau' => $id_panneau,
            'id_onduleur' => $id_onduleur,
            'id_installateur' => $data['id_installateur'],
            'nb_onduleur' => $data['nb_onduleur'],
            'pente' => $data['pente'],
            'puissance_pvgis' => $data['puissance_pvgis'],
            'pente_optimum' => $data['pente_optimum'],
            'orientation_optimum' => $data['orientation_optimum']
        ]);
        return $bool;

    }

// Suppression installation
    static function delete($db,$id){
        $stmt = $db->prepare("
            DELETE FROM installation WHERE id =:id;");
        $result = $stmt->execute(['id' => $id]);
        if (!$result) {
            error_log("DELETE failed: " . implode(" | ", $stmt->errorInfo()));
        }
        return $result;
    }

// Modification installation
    static function update($db, $id, $data,$id_pan,$id_ond) {
        $stmt = $db->prepare("UPDATE installation SET
        mois_installation = :mois,
        an_installation = :annee,
        nb_panneaux = :nb_panneaux,
        surface = :surface,
        puissance_crete = :puissance,
        orientation = :orientation,
        lat = :lat,
        lon = :lon,
        code_insee = :code_insee,
        id_installateur = :id_installateur,
        nb_onduleur = :nb_onduleur,
        pente = :pente,
        puissance_pvgis = :puissance_pvgis,
        pente_optimum = :pente_optimum,
        orientation_optimum = :orientation_optimum,
        id_panneau = :id_panneau,
        id_onduleur = :id_onduleur
        WHERE id = :id");

        return $stmt->execute([
            ':mois' => $data['mois_installation'],
            ':annee' => $data['an_installation'],
            ':nb_panneaux' => $data['nb_panneaux'],
            ':surface' => $data['surface'],
            ':puissance' => $data['puissance_crete'],
            ':orientation' => $data['orientation'],
            ':lat' => $data['lat'],
            ':lon' => $data['lon'],
            ':code_insee' => $data['code_insee'],
            ':id_installateur' => $data['id_installateur'],
            ':nb_onduleur' => $data['nb_onduleur'],
            ':pente' => $data['pente'],
            ':puissance_pvgis' => $data['puissance_pvgis'],
            ':pente_optimum' => $data['pente_optimum'],
            ':orientation_optimum' => $data['orientation_optimum'],
            ':id' => $id,
            'id_panneau' => $id_pan,
            'id_onduleur' => $id_ond
        ]);
    }
}