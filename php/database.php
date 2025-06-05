<?php
  require_once('constants.php');

//----------------------------------------------------------------------------
//--- dbConnect --------------------------------------------------------------
//----------------------------------------------------------------------------
// Crée la connexion à la base de données.
// \return False en cas d'erreur, sinon la base de données.
function dbConnect()
  {
    try
    {
      $db = new PDO('mysql:host='.DB_SERVER.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $exception)
    {
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
  }

// Nombre enregistrement en base
function countInstal($db){
  $stmt = $db->prepare("SELECT COUNT(*) AS total_installations FROM installation");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result['total_installations'];
}

// Nombre d'installations par années
function installByYear($db, $year){
  $sql = "SELECT COUNT(*) AS total 
        FROM installation 
        WHERE an_installation=:annee;";
  $stmt=$db->prepare($sql);
  $stmt->execute(['annee'=>$year]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results[0]['total'];
}

// Nombre d'installations par région
function installByRegion($db, $region){
  $stmt = $db->prepare("
    SELECT COUNT(*) AS total 
    FROM installation i
    JOIN commune c ON i.code_insee = c.code_insee
    JOIN departement d ON c.dep_code = d.dep_code
    JOIN region r ON d.reg_code = r.reg_code
    WHERE r.reg_code=:region;
");
  $stmt->execute(['region'=>$region]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results[0]['total'];
}

// Nombre d'installations par années et région
function installYearRegion($db, $year, $region){
  $stmt = $db->prepare("
    SELECT i.an_installation, r.reg_nom, COUNT(*) AS total 
    FROM installation i
    JOIN commune c ON i.code_insee = c.code_insee
    JOIN departement d ON c.dep_code = d.dep_code
    JOIN region r ON d.reg_code = r.reg_code
    WHERE r.reg_code=:region AND i.an_installation=:year;
");
  $stmt->execute(['region'=>$region, 'year'=>$year]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results[0]['total'];
}

// Nombre d'installateurs
function nbInstallateurs($db){
  $stmt = $db->prepare("SELECT COUNT(*) AS total_installateurs FROM installateur");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result['total_installateurs'];
}

// Nombre de marques d'onduleurs
function nbMarqueOnd($db){
  $stmt = $db->prepare("SELECT COUNT(*) AS nb_marque_onduleur FROM onduleur_marque");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result['nb_marque_onduleur'];
}

// Nombre de marques de panneaux solaires
function nbMarquePan($db){
  $stmt = $db->prepare("SELECT COUNT(*) AS nb_marque_panneau FROM panneaux_marque");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

// Installation par marque d'onduleur
function installByOnduleur($db,$marque){
  $stmt = $db->prepare("
    SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon 
    FROM installation i
    JOIN onduleur o ON o.id_onduleur = i.id_onduleur
    JOIN onduleur_marque om ON o.id_onduleur_marque = om.id_onduleur_marque
    WHERE om.id_onduleur_marque=:marque
    LIMIT 100;
");
  $stmt->execute(['marque'=>$marque]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Marque ondulateur
function marqueOnd($db){
  $stmt = $db->prepare("SELECT id_onduleur_marque,ondulateur_marque 
FROM onduleur_marque om
ORDER BY RAND()
LIMIT 20;");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;

}

// Installation par marque de panneau
function installByPanneau($db,$marque){
  $stmt = $db->prepare("
    SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon 
    FROM installation i
    JOIN panneau p ON p.id_panneau = i.id_panneau
    JOIN panneau_marque pm ON o.id_panneau_marque = pm.id_panneau_marque
    WHERE pm.id_panneau_marque=:marque
    LIMIT 100;
");
  $stmt->execute(['marque'=>$marque]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Marque panneau
function marquePan($db){
  $stmt = $db->prepare("SELECT id_panneau_marque,panneau_marque FROM panneaux_marque ORDER BY RAND() LIMIT 20;");
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
//Récupère 20 marques de panneau commençant par $text
function marquePanFiltre($db,$text){
    $stmt = $db->prepare("
        SELECT id_panneau_marque,panneau_marque FROM panneaux_marque 
        WHERE LOWER(panneau_marque) LIKE LOWER(:term) 
        LIMIT 20;
    ");
    $stmt->execute(['term'=>'%'.$text.'%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}


// Departements
function recupDep($db){
  $stmt = $db->prepare("Select dep_code,dep_nom from departement order by RAND() LIMIT 20;");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}
//Récupère 20 departement de panneau commençant par $text
function depFiltre($db,$text){
    $stmt = $db->prepare("
        Select dep_code,dep_nom from departement
        WHERE LOWER(dep_nom) LIKE LOWER(:term) 
        LIMIT 20;
    ");
    $stmt->bindParam('term','%'.$text.'%');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// Installation par departement
function installByDep($db,$dep){
  $stmt = $db->prepare("
    SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon
    FROM installation i
    JOIN Commune c ON i.code_insee = c.code_insee
    JOIN departement d ON c.dep_code = d.dep_code
    WHERE d.dep_code=:dep
    LIMIT 100;
");
  $stmt->execute(['dep'=>$dep]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Récupération infos d'une installation précise
function infosInstall($db,$id){
  $stmt = $db->prepare("
    SELECT 
    i.*,
    inst.installateur,
    c.nom_standard AS commune,
    c.code_postal,
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

WHERE i.id_installateur=:id;
");
  $stmt->execute(['id'=>$id]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Récupération infos de toutes les installations
function infosInstalls($db){
    $stmt = $db->prepare("
    SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon

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
    
LIMIT 100;
");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// Insertion d'installation
function insert($db,$data){
    $stmt = $db->prepare("
    INSERT INTO Installation (
  mois_installation, an_installation, nb_panneaux, surface, puissance_crete,
  orientation, lat, lon, commune_code_insee, id_panneau, id_onduleur, id_installateur)
    VALUES (=:mois,=:annee,=:nb,=:surface,=:pcrete,=:orientation,=:lat,:lon,:commune_code,=:id_panneau,:id_onduleur,:id_installateur);
 ");
    $stmt->execute(['mois'=>$data['mois'],'annee'=>$data['annee'],'nb'=>$data['nb_pan'],'surface'=>$data['surface'],'pcrete'=>$data['crete'],'orientation'=>$data['orientation'],'lat'=>$data['lat'],'lon'=>$data['lon'],'commune_code'=>$data['commune_code'],'id_panneau'=>$data['id_panneau'],'id_onduleur'=>$data['id_onduleur'],'id_installateur'=>$data['id_installateur']]);
}

// Suppression installation
function delete($db,$id){
    $stmt = $db->prepare("
   DELETE FROM Installation WHERE id =:id;
");
    $stmt->execute(['id'=>$id]);
}

// Modification installation
function update($db,$data,$id){
    $stmt = $db->prepare("
       UPDATE Installation
    SET nb_panneaux =:nb , surface =: surface, puissance_crete =: crete
    WHERE id =: id;
");
    $stmt->execute(['id'=>$id,'nb'=>$data['nb'],'surface'=>$data['surface'],'crete'=>$data['crete']]);
}

// Récup info sachant marque du panneau et de l'onduleur
function infosDeuxMarque($db,$panneau,$onduleur){
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

WHERE pmq.id_panneau_marque =:panneau  AND omq.id_onduleur_marque =: onduleur

LIMIT 100;

");
    $stmt->execute(['panneau'=>$panneau,'onduleur'=>$onduleur]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// Récup info sachant marque de l'onduleur et departement
function infosDepOndul($db,$dep,$onduleur){
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

WHERE d.dep_code =:dep  AND omq.id_onduleur_marque =: onduleur

LIMIT 100;

");
    $stmt->execute(['dep'=>$dep,'onduleur'=>$onduleur]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// Récup info sachant marque du panneau et departement
function infosDepPann($db,$dep,$panneau){
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

WHERE d.dep_code =:dep  AND pmq.id_panneau_marque =: panneau

LIMIT 100;

");
    $stmt->execute(['dep'=>$dep,'panneau'=>$panneau]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// Récup info sachant marque du panneau et de l'onduleur et le departement
function infosTrois($db,$dep,$panneau,$onduleur){
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

WHERE d.dep_code =:dep  AND pmq.id_panneau_marque =: panneau AND omq.id_onduleur_marque =: onduleur

LIMIT 100;

");
    $stmt->execute(['dep'=>$dep,'panneau'=>$panneau,'onduleur'=>$onduleur]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// Récupération coordonnées pour la carte
function coord($db,$dep,$annee){
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

//récupération de toutes les années
function annee($db){
    $stmt = $db->prepare("
   SELECT distinct(annee) as annee
   FROM installation;
   ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

//récupération de toutes les régions
function region($db){
    $stmt = $db->prepare("
   SELECT reg_code,reg_name
   FROM region;
   ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}