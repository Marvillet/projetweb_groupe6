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
        WHERE an_installation:=year;";
  $stmt=$db->prepare($sql);
  $stmt->execute(['year'=>$year]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Nombre d'installations par région
function installByRegion($db, $region){
  $stmt = $db->prepare("
    SELECT r.reg_nom,COUNT(*) AS total 
    FROM installation i
    JOIN Commune c ON i.code_insee = c.code_insee
    JOIN departement d ON c.dep_code = d.dep_code
    JOIN region r ON d.reg_code = r.reg_code
    WHERE i.reg_nom=:region;
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
    JOIN Commune c ON i.code_insee = c.code_insee
    JOIN departement d ON c.dep_code = d.dep_code
    JOIN region r ON d.reg_code = r.reg_code
    WHERE r.reg_nom=:region AND i.reg_nom=:year;
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
    SELECT * 
    FROM installation i
    JOIN onduleur o ON o.id_onduleur = i.id_onduleur
    JOIN onduleur_marque om ON o.id_onduleur_marque = om.id_onduleur_marque
    WHERE om.onduleur_marque=:marque;
");
  $stmt->execute(['marque'=>$marque]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Marque ondulateur
function marqueOnd($db){
  $stmt = $db->prepare("SELECT om.ondulateur_marque FROM onduleur_marque om");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;

}

// Installation par marque de panneau
function installByPanneau($db,$marque){
  $stmt = $db->prepare("
    SELECT * 
    FROM installation i
    JOIN panneau p ON p.id_panneau = i.id_panneau
    JOIN panneau_marque pm ON o.id_panneau_marque = pm.id_panneau_marque
    WHERE pm.panneau_marque=:marque;
");
  $stmt->execute(['marque'=>$marque]);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// Marque panneau
function marquePan($db){
  $stmt = $db->prepare("SELECT panneau_marque FROM panneaux_marque ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

