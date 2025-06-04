#-- Il faut executer data2.sql et communes-france-2024-limite.sql
INSERT INTO pays(id_pays, country) VALUE (1,'France');

INSERT INTO region(reg_code, reg_nom, id_pays) Select distinct reg_code, reg_nom, 1 from  data_commune ;

INSERT INTO departement(dep_code, dep_nom, reg_code) select distinct dep_code,dep_nom,reg_code from data_commune;

INSERT INTO commune(code_insee, nom_standard, code_postal, population, dep_code) select code_insee,nom_standard,data_commune.code_postal,data_commune.population,data_commune.dep_code from data_commune;
CREATE INDEX commune_index
    ON commune(nom_standard);