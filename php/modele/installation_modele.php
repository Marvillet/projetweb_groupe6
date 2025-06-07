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
                omq.onduleur_marque
            
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
    static function insert($db,$data){
        $stmt = $db->prepare("INSERT INTO installation (mois_installation, an_installation, nb_panneaux, surface, puissance_crete, orientation, lat, lon,
                                code_insee, id_panneau, id_onduleur, id_installateur, nb_onduleur, pente, puissance_pvgis,
                                pente_optimum, orientation_optimum)
                                VALUES (:mois, :annee, :nb, :surface, :pcrete, :orientation, :lat, :lon,
                                :commune_code, :id_panneau, :id_onduleur, :id_installateur, :nb_onduleur, :pente, :pvgis,
                                :p_optimum, :orientation_optimum);");
        $stmt->execute([
            'mois' => $data['mois'],
            'annee' => $data['annee'],
            'nb' => $data['nb_pan'],
            'surface' => $data['surface'],
            'pcrete' => $data['crete'],
            'orientation' => $data['orientation'],
            'lat' => $data['lat'],
            'lon' => $data['lon'],
            'commune_code' => $data['commune_code'],
            'id_panneau' => $data['id_panneau'],
            'id_onduleur' => $data['id_onduleur'],
            'id_installateur' => $data['id_installateur'],
            'nb_onduleur' => $data['nb_onduleur'],
            'pente' => $data['pente'],
            'pvgis' => $data['pvgis'],
            'p_optimum' => $data['pente_optimum'],
            'orientation_optimum' => $data['orientation_optimum']
        ]);

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
    static function update($db,$id,$data){
        $stmt = $db->prepare("UPDATE installations SET
        mois_installation = :mois,
        an_installation = :annee,
        nb_panneaux = :nb_panneaux,
        marque_panneaux = :marque_p,
        modele_panneaux = :modele_p,
        nb_onduleurs = :nb_onduleurs,
        marque_onduleur = :marque_o,
        modele_onduleur = :modele_o,
        puissance_crete = :puissance,
        surface = :surface,
        pente = :pente,
        orientation = :orientation,
        orientation_opt = :orientation_opt,
        installateur = :installateur,
        pvgis = :pvgis,
        latitude = :lat,
        longitude = :lon,
        pays = :pays,
        code_postal = :cp,
        localite = :localite,
        region = :region,
        departement = :departement
        WHERE id = :id
    ");

        $stmt->execute([
            ':mois' => $data['mois_installation'],
            ':annee' => $data['an_installation'],
            ':nb_panneaux' => $data['nb_panneaux'],
            ':marque_p' => $data['marque_panneaux'],
            ':modele_p' => $data['modele_panneaux'],
            ':nb_onduleurs' => $data['nb_onduleurs'],
            ':marque_o' => $data['marque_onduleur'],
            ':modele_o' => $data['modele_onduleur'],
            ':puissance' => $data['puissance_crete'],
            ':surface' => $data['surface'],
            ':pente' => $data['pente'],
            ':orientation' => $data['orientation'],
            ':orientation_opt' => $data['orientation_opt'],
            ':installateur' => $data['installateur'],
            ':pvgis' => $data['pvgis'],
            ':lat' => $data['latitude'],
            ':lon' => $data['longitude'],
            ':pays' => $data['pays'],
            ':cp' => $data['code_postal'],
            ':localite' => $data['localite'],
            ':region' => $data['region'],
            ':departement' => $data['departement'],
            ':id' => $id
        ]);
    }
}