<?php
  require_once('database.php');

  // Connexion à la bdd
  $db = dbConnect();
  if (!$db)
  {
    header('HTTP/1.1 503 Service Unavailable');
    exit;
  }

  // Vérifie la requête
  $requestMethod = $_SERVER['REQUEST_METHOD'];
  $request = substr($_SERVER['PATH_INFO'], 1);
  $request = explode('/', $request);
  $requestRessource = array_shift($request);
  
  // Vérifie l'id associé à la requête
  $id = array_shift($request);
  if ($id == '')
    $id = NULL;

  //On récupère les datas en fonctions de la méthode
  switch ($requestMethod) {
    case 'GET':
      $data = $_GET;
      break;
    case 'POST':
      $data = $_POST;
      break;
    case 'PUT':
    case 'DELETE':
      $data = json_decode(file_get_contents("php://input"), true);
      break;
    default:
      //http_response_code(405);
      echo json_encode(["error" => "Méthode non autorisée"]);
      exit;
  }

  //si la requête porte sur une installation
  switch ($requestRessource) {
    case "stat":
      require_once "controleur/statistique_controleur.php";
      //ici l'id représente la stat demandée
      GestionDemande($db,$requestMethod,$id,$data);
      break;
    case "installation":
      require_once "controleur/installation_controleur.php";
      GestionDemande($db,$requestMethod,$id,$data);
      break;
    case "panneau":
      require_once "controleur/panneau_controleur.php";
      GestionDemande($db,$requestMethod,$id,$data);
      break;
    case "onduleur":
      require_once "controleur/onduleur_controleur.php";
      GestionDemande($db,$requestMethod,$id,$data);
      break;
    case "date":
      require_once "controleur/date_controleur.php";
      GestionDemande($db,$requestMethod,$id,$data);
      break;
    case "recherche":
      require_once "controleur/recherche_controleur.php";
      GestionDemande($db,$requestMethod,$id,$data);
      break;
    case "lieu":
      require_once "controleur/lieu_controleur.php";
      GestionDemande($db,$requestMethod,$id,$data);
      break;
    case "admin":
      require_once "controleur/admin_controleur.php";
      GestionDemande($db,$requestMethod,$id,$data);
      break;
    case 'test':
      echo "oui";
      break;
    default:
      echo json_encode(["error" => "Ressource inexistante"]);

  }
  exit;
?>
