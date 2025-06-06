<?php

class date
{

//récupération de toutes les années
    static function annee($db){
        $stmt = $db->prepare("
           SELECT distinct(an_installation) as annee
           FROM installation
            ORDER BY Rand()
            LIMIT 20;");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}