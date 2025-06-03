#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: panneaux_marque
#------------------------------------------------------------
DROP TABLE if exists installation;
DROP TABLE if exists onduleur;
DROP TABLE if exists onduleur_marque;
DROP TABLE if exists panneau;
DROP TABLE if exists commune;
DROP Table if exists installateur;
DROP TABLE if exists departement;
DROP TABLE if exists region;
DROP TABLE if exists pays;
DROP TABLE if exists onduleur_modele;
DROP Table if exists panneaux_modele;
DROP TABLE if exists panneaux_marque;

CREATE TABLE panneaux_marque(
                                id_panneaux_marque Int NOT NULL ,
                                panneaux_marque    Varchar (50) NOT NULL
    ,CONSTRAINT panneaux_marque_PK PRIMARY KEY (id_panneaux_marque)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: panneaux_modele
  #------------------------------------------------------------

CREATE TABLE panneaux_modele(
                                id_modele_panneau Int NOT NULL ,
                                panneaux_modele   Varchar (50) NOT NULL
    ,CONSTRAINT panneaux_modele_PK PRIMARY KEY (id_modele_panneau)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: onduleur_modele
  #------------------------------------------------------------

CREATE TABLE onduleur_modele(
                                id_modele_onduleur Int NOT NULL ,
                                onduleur_modele    Varchar (50) NOT NULL
    ,CONSTRAINT onduleur_modele_PK PRIMARY KEY (id_modele_onduleur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Installateur
  #------------------------------------------------------------

CREATE TABLE installateur(
                             id_installateur Int NOT NULL ,
                             installateur    Varchar (50) NOT NULL
    ,CONSTRAINT Installateur_PK PRIMARY KEY (id_installateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Pays
  #------------------------------------------------------------

CREATE TABLE pays(
                     id_pays Int NOT NULL ,
                     country Varchar (50) NOT NULL
    ,CONSTRAINT Pays_PK PRIMARY KEY (id_pays)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: region
  #------------------------------------------------------------

CREATE TABLE region(
                       reg_code  Int NOT NULL ,
                       reg_nom   Varchar (50) NOT NULL ,
                       id_pays   Int NOT NULL
    ,CONSTRAINT region_PK PRIMARY KEY (reg_code)

    ,CONSTRAINT region_Pays_FK FOREIGN KEY (id_pays) REFERENCES pays(id_pays)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: departement
  #------------------------------------------------------------
;
CREATE TABLE departement(
                            dep_code  varchar(5) NOT NULL ,
                            dep_nom   Varchar (50) NOT NULL ,
                            reg_code  Int NOT NULL
    ,CONSTRAINT departement_PK PRIMARY KEY (dep_code)

    ,CONSTRAINT departement_region_FK FOREIGN KEY (reg_code) REFERENCES region(reg_code)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Commune
  #------------------------------------------------------------

CREATE TABLE commune(
                        code_insee   Varchar(10) NOT NULL ,
                        nom_standard Varchar (50) NOT NULL ,
                        code_postal  Int NOT NULL ,
                        population   Int NOT NULL ,
                        dep_code     VARCHAR(5) NOT NULL
    ,CONSTRAINT Commune_PK PRIMARY KEY (code_insee)

    ,CONSTRAINT Commune_departement_FK FOREIGN KEY (dep_code) REFERENCES departement(dep_code)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: panneau
  #------------------------------------------------------------

CREATE TABLE panneau(
                        id_panneau         Int NOT NULL ,
                        id_modele_panneau  Int NOT NULL ,
                        id_panneaux_marque Int NOT NULL
    ,CONSTRAINT panneau_PK PRIMARY KEY (id_panneau)

    ,CONSTRAINT panneau_panneaux_modele_FK FOREIGN KEY (id_modele_panneau) REFERENCES panneaux_modele(id_modele_panneau)
    ,CONSTRAINT panneau_panneaux_marque0_FK FOREIGN KEY (id_panneaux_marque) REFERENCES panneaux_marque(id_panneaux_marque)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: onduleur_marque
  #------------------------------------------------------------

CREATE TABLE onduleur_marque(
                                id_marque       Int NOT NULL ,
                                onduleur_marque Varchar (50) NOT NULL
    ,CONSTRAINT onduleur_marque_PK PRIMARY KEY (id_marque)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: onduleur
  #------------------------------------------------------------

CREATE TABLE onduleur(
                         id_onduleur        Int NOT NULL ,
                         id_marque          Int NOT NULL ,
                         id_modele_onduleur Int NOT NULL
    ,CONSTRAINT onduleur_PK PRIMARY KEY (id_onduleur)

    ,CONSTRAINT onduleur_onduleur_marque_FK FOREIGN KEY (id_marque) REFERENCES onduleur_marque(id_marque)
    ,CONSTRAINT onduleur_onduleur_modele0_FK FOREIGN KEY (id_modele_onduleur) REFERENCES onduleur_modele(id_modele_onduleur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: installation
  #------------------------------------------------------------

CREATE TABLE installation(
                             id                  Int NOT NULL ,
                             mois_installation   Int NOT NULL ,
                             an_installation     Int NOT NULL ,
                             nb_panneaux         Int NOT NULL ,
                             nb_onduleur         Int NOT NULL ,
                             lat                 Float NOT NULL ,
                             lon                 Float NOT NULL ,
                             puissance_crete     Int NOT NULL ,
                             surface             Int NOT NULL ,
                             pente               Int NOT NULL ,
                             pente_optimum       Int,
                             orientation         Int NOT NULL ,
                             orientation_optimum Int NOT NULL ,
                             puissance_pvgis     Int NOT NULL ,
                             id_panneau          Int NOT NULL ,
                             id_onduleur         Int NOT NULL ,
                             code_insee          VARCHAR(10) NOT NULL ,
                             id_installateur     Int
    ,CONSTRAINT installation_PK PRIMARY KEY (id)

    ,CONSTRAINT installation_panneau_FK FOREIGN KEY (id_panneau) REFERENCES panneau(id_panneau)
    ,CONSTRAINT installation_onduleur0_FK FOREIGN KEY (id_onduleur) REFERENCES onduleur(id_onduleur)
    ,CONSTRAINT installation_Commune1_FK FOREIGN KEY (code_insee) REFERENCES commune(code_insee)
    ,CONSTRAINT installation_Installateur2_FK FOREIGN KEY (id_installateur) REFERENCES installateur(id_installateur)
)ENGINE=InnoDB;