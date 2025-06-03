#-- executer tous les autres sql avant
INSERT INTO panneaux_marque(panneaux_marque) SELECT distinct panneaux_marque from mytable;

insert into panneaux_modele(panneaux_modele) SELECT DISTINCT mytable.panneaux_modele from mytable;

insert into panneau(id_modele_panneau, id_panneaux_marque) SELECT