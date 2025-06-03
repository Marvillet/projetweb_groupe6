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