INSERT INTO installateur (installateur) SELECT distinct installateur FROM mytable;

INSERT INTO onduleur_marque(onduleur_marque) SELECT distinct onduleur_marque from mytable;

insert into onduleur_modele(onduleur_modele) SELECT DISTINCT mytable.onduleur_modele from mytable;