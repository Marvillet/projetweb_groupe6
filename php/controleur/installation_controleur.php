<?php
switch ($requestMethod) {
    case 'GET':
        if ($id) {
            //on renvoie les data d'une installation précise
            $data = 'installation de l\'id id';
        } else {
            $data = '100 installations avec moins de data';
        }
        break;
    case 'POST':
        if (isset($_POST['id']) && isset($_POST['comment'])) {
            $data = 'on ajoute la data';
        }
        break;
    case 'DELETE':
        if ($id != NULL) {
            $data = 'on supprime la data d\'id ';
        }
        break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), $_PUT);
        if (isset($_PUT['comment']) && $id != NULL) {
            $data = dbModifyComment($db, $login, $id, $_PUT['comment']);
        }
}