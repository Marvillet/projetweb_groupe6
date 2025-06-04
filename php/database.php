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
  $sql = "SELECT an_installation,COUNT(*) AS total 
        FROM installation 
        WHERE an_installation:=annee;";
  $stmt=$db->prepare($sql);
  $stmt->execute(['annee'=>$year]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Nombre d'installations par région
function installByRegion($db, $region){
  $stmt = $db->prepare("
    SELECT r.reg_nom,COUNT(*) AS total 
    FROM installation i
    JOIN commune c ON i.code_insee = c.code_insee
    JOIN departement d ON c.dep_code = d.dep_code
    JOIN region r ON d.reg_code = r.reg_code
    WHERE i.reg_code:=region;
");
  $stmt->execute(['region'=>$region]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Nombre d'installations par années et région
function installYearRegion($db, $year, $region){
  $stmt = $db->prepare("
    SELECT i.an_installation, r.reg_nom, COUNT(*) AS total 
    FROM installation i
    JOIN commune c ON i.code_insee = c.code_insee
    JOIN departement d ON c.dep_code = d.dep_code
    JOIN region r ON d.reg_code = r.reg_code
    WHERE r.reg_nom:=region AND i.reg_nom:=year;
");
  $stmt->execute(['region'=>$region, 'year'=>$year]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Nombre d'installateurs
function nbInstallateurs($db){
  $stmt = $db->prepare("SELECT COUNT(*) AS total_installateurs FROM installateur");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

// Nombre de marques d'onduleurs
function nbMarqueOnd($db){
  $stmt = $db->prepare("SELECT COUNT(*) AS nb_marque_onduleur FROM onduleur_marque");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

// Nombre de marques de panneaux solaires
function nbMarquePan($db){
  $stmt = $db->prepare("SELECT COUNT(*) AS nb_marque_panneau FROM panneaux_marque");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

// Installation par marque d'onduleur
function installByOnduleur($db,$marque){
  $stmt = $db->prepare("
    SELECT id,mois_installation,an_installation,nb_panneaux,surface,puissance_crete,lat,lon 
    FROM installation i
    JOIN onduleur o ON o.id_onduleur = i.id_onduleur
    JOIN onduleur_marque om ON o.id_onduleur_marque = om.id_onduleur_marque
    WHERE om.onduleur_marque:=marque;
");
  $stmt->execute(['marque'=>$marque]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Marque ondulateur
function marqueOnd($db){
  $stmt = $db->prepare("SELECT id_onduleur_marque,ondulateur_marque FROM onduleur_marque om");
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
    WHERE pm.panneau_marque:=marque;
");
  $stmt->execute(['marque'=>$marque]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Marque panneau
function marquePan($db){
  $stmt = $db->prepare("SELECT id_panneau_marque,panneau_marque FROM panneaux_marque ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

// Departements
function recupDep($db){
  $stmt = $db->prepare("Select dep_code,dep_nom from departement");
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
    WHERE d.dep_nom:=dep;
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

// Insertion d'installation
function insert($db,$data){
    $stmt = $db->prepare("
    INSERT INTO Installation (
  mois_installation, an_installation, nb_panneaux, surface, puissance_crete,
  orientation, lat, lon, commune_code_insee, id_panneau, id_onduleur, id_installateur)
    VALUES (:=mois,:=annee,:=nb,:=surface,:=pcrete,:=orientation,:=lat,:lon,:commune_code_insee,:=id_panneau,:id_onduleur,:id_installateur);
 ");
    $stmt->execute(['mois'=>$data['mois'],'annee'=>$data['annee'],'']);
}