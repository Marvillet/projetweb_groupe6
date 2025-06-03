#-- executer tous les autres sql avant
INSERT INTO panneaux_marque(panneaux_marque) SELECT distinct panneaux_marque from mytable;

insert into panneaux_modele(panneaux_modele) SELECT DISTINCT mytable.panneaux_modele from mytable;

insert into panneau(id_modele_panneau, id_panneaux_marque)
    SELECT DISTINCT modele.id_modele_panneau,marque.id_panneaux_marque from mytable
    INNER JOIN panneaux_modele modele using (panneaux_modele)
    INNER JOIN panneaux_marque marque using(panneaux_marque);

INSERT INTO installateur (installateur) SELECT distinct installateur FROM mytable;

INSERT INTO onduleur_marque(onduleur_marque) SELECT distinct onduleur_marque from mytable;

insert into onduleur_modele(onduleur_modele) SELECT DISTINCT mytable.onduleur_modele from mytable;

INSERT INTO onduleur (id_marque, id_modele_onduleur)
SELECT DISTINCT m.id_marque, mo.id_modele_onduleur
FROM mytable t
         JOIN onduleur_marque m ON t.onduleur_marque = m.onduleur_marque
         JOIN onduleur_modele mo ON t.onduleur_modele = mo.onduleur_modele;
