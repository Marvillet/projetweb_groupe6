#-- executer tous les autres sql avant
INSERT INTO panneaux_marque(panneau_marque) SELECT distinct panneaux_marque from mytable;
CREATE INDEX panneaux_marque_index
    ON panneaux_marque(panneau_marque);

insert into panneaux_modele(panneau_modele) SELECT DISTINCT mytable.panneaux_modele from mytable;
CREATE INDEX panneaux_modele_index
    ON panneaux_modele(panneau_modele);

insert into panneau(id_panneau_modele, id_panneau_marque)
    SELECT DISTINCT modele.id_panneau_modele,marque.id_panneau_marque from mytable
    INNER JOIN panneaux_modele modele on modele.panneau_modele=mytable.panneaux_modele
    INNER JOIN panneaux_marque marque on marque.panneau_marque=mytable.panneaux_marque;

INSERT INTO installateur (installateur) SELECT distinct installateur FROM mytable;

INSERT INTO onduleur_marque(onduleur_marque) SELECT distinct onduleur_marque from mytable;
CREATE INDEX onduleur_marque_index
    ON onduleur_marque(onduleur_marque);

insert into onduleur_modele(onduleur_modele) SELECT DISTINCT mytable.onduleur_modele from mytable;
CREATE INDEX onduleur_modele_index
    ON onduleur_modele(onduleur_modele);

INSERT INTO onduleur (id_onduleur_marque, id_onduleur_modele)
SELECT DISTINCT marque.id_onduleur_marque, modele.id_onduleur_modele
FROM mytable t
        INNER JOIN onduleur_marque marque ON t.onduleur_marque = marque.onduleur_marque
         INNER JOIN onduleur_modele modele ON t.onduleur_modele = modele.onduleur_modele;

ALTER TABLE installation
    MODIFY  orientation_optimum INT;

insert into installation(id, mois_installation, an_installation, nb_panneaux, nb_onduleur, lat, lon, puissance_crete, surface, pente, pente_optimum, orientation, orientation_optimum, puissance_pvgis, id_panneau, id_onduleur, code_insee, id_installateur)
SELECT mytable.id,mytable.mois_installation , mytable.an_installation,mytable.nb_panneaux,mytable.nb_onduleur,mytable.lat,mytable.lon,mytable.puissance_crete,mytable.surface,mytable.pente,mytable.pente_optimum,mytable.orientation,mytable.orientation_optimum,mytable.production_pvgis,panneau.id_panneau,onduleur.id_onduleur,commune.code_insee,installateur.id_installateur
from mytable
inner join panneaux_marque on mytable.panneaux_marque=panneaux_marque.panneau_marque
inner join panneaux_modele on mytable.panneaux_modele=panneaux_modele.panneau_modele
inner join panneau on
    panneaux_marque.id_panneau_marque = panneau.id_panneau_marque
    and panneaux_modele.id_panneau_modele = panneau.id_panneau_modele

INNER JOIN onduleur_marque ON mytable.onduleur_marque = onduleur_marque.onduleur_marque
INNER JOIN onduleur_modele ON mytable.onduleur_modele = onduleur_modele.onduleur_modele
INNER JOIN onduleur ON
    onduleur_marque.id_onduleur_marque = onduleur.id_onduleur_marque AND
    onduleur_modele.id_onduleur_modele = onduleur.id_onduleur_modele

INNER JOIN installateur ON mytable.installateur=installateur.installateur
LEFT JOIN commune ON commune.nom_standard=mytable.locality and commune.code_postal=mytable.postal_code;

drop table if exists mytable;
drop table if exists data_commune;

