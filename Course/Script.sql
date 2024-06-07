  create  database course;
          create  table admin(
              id serial primary key ,
              login varchar(25),
              pwd varchar(25)
          );
insert into admin(login, pwd) values ('admin','admin');
create  table equipe(
              id serial primary key ,
              nom varchar(25),
              login varchar(25),
              pwd varchar(25)
          );
  insert into equipe (nom, login, pwd)
  values ('equipe A','a','a');
insert into equipe (nom, login, pwd)
  values ('equipe B','b','b');
insert into equipe (nom, login, pwd)
  values ('equipe C','c','c');

create  table  categorie(
    id serial primary key ,
    nom varchar(25),
    age int
);
insert into categorie(nom) values ('Homme',);
insert into categorie(nom) values ('Femme');
insert into categorie(nom) values ('Junior');
insert into categorie(nom) values ('Senior');

create  table coureur(
    id serial primary key ,
    nom varchar(25),
    numD int unique ,
    genre varchar(25),
    Dtn date,
    idEquipe int references equipe(id)
);
  INSERT INTO coureur (nom, numD, genre, Dtn, idEquipe) VALUES ('Sabi', 101, 'Homme', '1990-05-15', 54);
  INSERT INTO coureur (nom, numD, genre, Dtn, idEquipe) VALUES ('Fex', 102, 'Homme', '1992-07-22', 54);
  INSERT INTO coureur (nom, numD, genre, Dtn, idEquipe) VALUES ('Jim', 103, 'Homme', '1988-03-10', 54);
  INSERT INTO coureur (nom, numD, genre, Dtn, idEquipe) VALUES ('Mano', 104, 'Homme', '1995-12-30', 55);
  INSERT INTO coureur (nom, numD, genre, Dtn, idEquipe) VALUES ('Mo', 105, 'Homme', '1985-11-18', 55);
  INSERT INTO coureur (nom, numD, genre, Dtn, idEquipe) VALUES ('Dior', 106, 'Homme', '1985-11-19',55);
  INSERT INTO coureur (nom, numD, genre, Dtn, idEquipe) VALUES ('Le', 107, 'Homme', '1985-11-20', 56);
  INSERT INTO coureur (nom, numD, genre, Dtn, idEquipe) VALUES ('Tsiory', 108, 'Homme', '1985-11-21', 56);
  INSERT INTO coureur (nom, numD, genre, Dtn, idEquipe) VALUES ('Tsong', 109, 'Homme', '1985-11-21', 56);

create  table  categori_coureur(
    Cat  varchar(50),
    idCoureur int references  coureur(id)
);
-- insert into categori_coureur(idCat, idCoureur)  values (1,1);
-- insert into categori_coureur(idCat, idCoureur)  values (3,1);
-- insert into categori_coureur(idCat, idCoureur)  values (1,2);
-- insert into categori_coureur(idCat, idCoureur)  values (1,3);
-- insert into categori_coureur(idCat, idCoureur)  values (1,4);
-- insert into categori_coureur(idCat, idCoureur)  values (1,5);
-- insert into categori_coureur(idCat, idCoureur)  values (1,10);
-- insert into categori_coureur(idCat, idCoureur)  values (1,11);
-- insert into categori_coureur(idCat, idCoureur)  values (1,12);
-- insert into categori_coureur(idCat, idCoureur)  values (1,13);
-- insert into categori_coureur(idCat, idCoureur)  values (4,13);

create  table  etape(
    id serial primary key ,
    nom varchar(25),
    longuer float,
    nb_coureur_equipe int,
    rang_etape int,
    dateDepart date,
    date_heure_depart timestamp
);
insert into etape( nom, longuer, nb_coureur_equipe, rang_etape,dateDepart,date_heure_depart)  values ('Betsizaraina',100,2,1,'2024-01-06 ',' 2024-01-06 09:00:00');
insert into etape( nom, longuer, nb_coureur_equipe, rang_etape,dateDepart,date_heure_depart)  values ('Ampasimbe',120,3,2,'2024-01-07 ', '2024-01-07 09:00:00');
insert into etape( nom, longuer, nb_coureur_equipe, rang_etape,dateDepart,date_heure_depart)  values ('Betsizaraina',50,1,3,'2024-01-08',' 2024-01-08 09:00:00');

create  table coureur_etape(
    id serial primary key ,
    idCoureur int references coureur(id),
    idEtapes int references etape(id)
);
create  table temps_coureur_etape(
    id serial primary key ,
    ide int references  etape(id),
    idc int references coureur(id),
    arriver timestamp
);
--
create  or replace view v_temps_coureur_etape as
        select tce.id as tce_id ,tce.ide,tce.idc, c.idequipe,eq.nom as nom_equipe,c.nom,c.numd,c.dtn,e.id as e_id,e.date_heure_depart,tce.arriver,TO_CHAR((tce.arriver-e.date_heure_depart),'DD HH24:MI:SS') AS temp_effectuer_hh,
               EXTRACT(EPOCH FROM (tce.arriver-e.date_heure_depart))/60 AS temp_effectuer_mm
        from
        temps_coureur_etape tce
        join etape e on tce.ide = e.id
        join coureur c on tce.idc  = c.id
        join equipe eq on c.idEquipe = eq.id;
--
create or replace view v_classement as
       select  *,DENSE_RANK()OVER(PARTITION BY ide order by temp_effectuer_mm asc ) as classement
       from v_temps_coureur_etape;
--temps_coureur_etape where ide = 146
create  or replace view v_classement_equipe as
select vc.*,coalesce(p.points,0) as points
from v_classement vc
 left join point  p on   vc.classement = p.classement;
--
create  or replace view v_classement_equipe2 as
  select vc.idequipe,vc.nom_equipe,sum(points) as total_pts
  from v_classement_equipe vc
  group by vc.idequipe,vc.nom_equipe;
-- viewCoureur
  create  or replace view v_coureur_age as
  SELECT
      c.id,
      c.genre,
      c.dtn,
      EXTRACT(YEAR FROM AGE(CURRENT_DATE, c.dtn)) AS age
  FROM
      coureur c;
  -- view  classement_categorie
  create  or replace view v_classement_equipe_categ as
  select vc.idequipe,vc.nom_equipe,vc.points,cc.cat
  from v_classement_equipe vc
  join  categori_coureur cc
  on vc.idc =  cc.idCoureur;
-- calcul
create  or replace view calcul  as
        select  idequipe,nom_equipe,cat,sum(points)  from v_classement_equipe_categ group by  idequipe,nom_equipe,cat;
--
 create   or replace view  v_calcul as
  SELECT nom_equipe, cat, SUM(sum) AS total_points
  FROM calcul
  GROUP BY nom_equipe,cat
  ORDER BY nom_equipe, total_points DESC;
--
create  table  point(
classement int,
points int
);
--
create  table resultat(
    etape_rang int,
    numero_dossard int,
    nom  varchar(25),
    genre varchar(50),
    date_naissance date,
    equipe varchar(50),
    arriver timestamp
);
--
-- select  distinct equipe from resultat;
create  table  penalite(
    id_penalite serial primary key ,
    id_etapes int references etape(id),
    id_equipe int references  equipe(id),
    temps time
);
-- ,vc.* , coalesce(p.temps,'00:00:00') as penalite
--   select  p.id_etapes,p.temps,vc.*,(EXTRACT(EPOCH FROM (vc.arriver-vc.date_heure_depart))+EXTRACT(EPOCH  FROM  p.temps)) as temp_penaliter_plus
--      TO_CHAR((vc.arriver-vc.date_heure_depart+p.temps),'DD HH24:MI:SS')
--      from v_classement vc
--      join penalite p on vc.ide = p.id_etapes and vc.idequipe = p.id_equipe;
--       TO_CHAR((vc.arriver-vc.date_heure_depart+p.temps),'DD HH24:MI:SS')

-- create  or replace view v_penalite as
--   select  p.id_etapes,p.temps,vc.*,(vc.arriver-vc.date_heure_depart+p.temps) as temp_penaliter_plus
--   from v_classement vc
--            join penalite p on vc.ide = p.id_etapes and vc.idequipe = p.id_equipe;
--       vc.arriver - vc.date_heure_depart + p.temps AS temp_penaliter_plus
--
create or replace view sum_penalite as
       select p.id_equipe, p.id_etapes,sum(temps)  as temp from penalite p  group by id_equipe,id_etapes;

create  or replace view v_penalite as
  SELECT
      vc.tce_id,
      vc.ide,
      COALESCE(p.temp,'00:00:00') as temps,
      vc.idc,vc.idequipe,vc.nom_equipe,vc.nom,vc.numd,vc.dtn,vc.date_heure_depart,vc.arriver,vc.temp_effectuer_hh,vc.temp_effectuer_mm,vc.classement,vc.points
  FROM
      v_classement_equipe vc
          LEFT JOIN
      sum_penalite p ON vc.ide = p.id_etapes AND vc.idequipe = p.id_equipe;
--
create  or replace view v_penalite_plus as
        select
        vp.*, vp.arriver - vp.date_heure_depart + vp.temps AS temp_penaliter_plus
        from v_penalite vp ;


  create or replace view v_penal as
  select  *,DENSE_RANK()OVER(PARTITION BY ide order by temp_penaliter_plus asc ) as cla
  from v_penalite_plus;

  create  or replace view v_classement_equipe_p as
  select vc.*,coalesce(p.points,0) as pts
  from v_penal vc
           left join point  p on   vc.cla = p.classement ;
--
-- penalite_equipe
  create  or replace view v_classement_equipe_p2 as
  select vc.idequipe , vc.nom_equipe , sum(pts) as total_pts
  from v_classement_equipe_p vc
  group by vc.idequipe,vc.nom_equipe;

 create  or replace view v_classement_equipe_p22 as
  SELECT
      idequipe,
      nom_equipe,
      total_pts,
      DENSE_RANK() OVER (ORDER BY total_pts DESC) AS rank
  FROM
      v_classement_equipe_p2;
--
-- view  classement_categorie
  create  or replace view v_classement_equipe_categ as
  select vc.idequipe,vc.nom_equipe,vc.points,cc.cat
  from v_classement_equipe_p vc
           join  categori_coureur cc
                 on vc.idc =  cc.idCoureur;
-- calcul
  create  or replace view calcul  as
  select  idequipe,nom_equipe,cat,sum(points)   from v_classement_equipe_categ group by  idequipe,nom_equipe,cat;
--
  create   or replace view  v_calcul as
  SELECT nom_equipe, cat, SUM(sum) AS total_points
  FROM calcul
  GROUP BY nom_equipe,cat
  ORDER BY nom_equipe, total_points DESC;
-- vue toute_categ
create  or replace view toute_cat as
  select distinct cat from v_calcul;
--  classement categori_coureur
  create   or replace  view v_genre_categori_coureur as
  SELECT
      categori_coureur.cat,
      coureur.id AS coureur_id,
      coureur.nom AS coureur_nom,
      coureur.numd,
      coureur.genre,
      coureur.dtn,
      coureur.idequipe
  FROM
      categori_coureur
          JOIN
      coureur ON categori_coureur.idcoureur = coureur.id;
--
--     p.ide,p.e_id,
create  or replace view  pts_categorie_coueur as
  SELECT
      p.ide,
      p.temps,
      p.idc,
      p.idequipe,
      p.tce_id,
      p.nom_equipe,
      p.nom,
      p.numd,
      p.dtn,
      p.date_heure_depart,
      p.arriver,
      p.temp_effectuer_hh,
      p.temp_effectuer_mm,
      p.classement,
      p.points,
      p.temp_penaliter_plus,
      p.cla,
      g.cat,
      g.genre
  FROM
      v_penal p
    JOIN
      v_genre_categori_coureur g
      ON
    p.idc = g.coureur_id;

-- with rang_penal AS ( select *,DENSE_RANK()OVER(PARTITION BY ide,cat order by temp_penaliter_plus asc ) as cla
-- from v_temps_penaliter)
-- SELECT
--     p.id_etapes,
--     p.temps,
--     p.tce_id,
--     p.ide,
--     p.idc,
--     p.idequipe,
--     p.nom_equipe,
--     p.nom,
--     p.numd,
--     p.dtn,
--     p.e_id,
--     p.date_heure_depart,
--     p.arriver,
--     p.temp_effectuer_hh,
--     p.temp_effectuer_mm,
--     p.classement,
--     p.points,
--     p.temp_penaliter_plus,
--     p.cla,
--     g.cat,
--     g.genre
-- FROM rang_penal p
--  join
--      v_genre_categori_coureur g
--      ON
--              p.idc = g.coureur_id;
--
-- tres util pour classement
  select *,DENSE_RANK()OVER(PARTITION BY ide,genre order by temp_penaliter_plus asc ) as cla
  ,coalesce(p.points,0) as pts
  from v_temps_penaliter vc
   left join point  p on   vc.cla = p.classement where genre='F';
  WITH point AS (
      SELECT
          vc.*,
          DENSE_RANK() OVER (PARTITION BY vc.ide, vc.cat ORDER BY vc.temp_penaliter_plus ASC) AS cla,
          COALESCE(p.points, 0) AS pts
      FROM
          v_temps_penaliter vc
              LEFT JOIN
          point p ON vc.cla = p.classement
      WHERE
      vc.cat = 'Senior'
  )
  SELECT
      vc.idequipe,
      vc.nom_equipe,
      SUM(vc.pts) AS total_pts,
      DENSE_RANK() OVER (ORDER BY SUM(vc.pts) DESC) AS rang
  FROM
      point vc
  GROUP BY
      vc.idequipe, vc.nom_equipe;


create or replace  view v_temps_penaliter as
  SELECT
      v_penalite_plus.ide,
      v_penalite_plus.temps,
      v_penalite_plus.tce_id,
      v_penalite_plus.idc,
      v_penalite_plus.idequipe,
      v_penalite_plus.nom_equipe,
      v_penalite_plus.nom,
      v_penalite_plus.numd,
      v_penalite_plus.dtn,
      v_penalite_plus.date_heure_depart,
      v_penalite_plus.arriver,
      v_penalite_plus.temp_effectuer_hh,
      v_penalite_plus.temp_effectuer_mm,
      v_penalite_plus.classement,
      v_penalite_plus.points,
      v_penalite_plus.temp_penaliter_plus,
      pts_categorie_coueur.cla,
      pts_categorie_coueur.cat,
      pts_categorie_coueur.genre
  FROM
      v_penalite_plus
          JOIN
      pts_categorie_coueur
      ON
                  v_penalite_plus.tce_id = pts_categorie_coueur.tce_id
              AND v_penalite_plus.ide = pts_categorie_coueur.ide
              AND v_penalite_plus.idc = pts_categorie_coueur.idc
              AND v_penalite_plus.idequipe = pts_categorie_coueur.idequipe;

create  or replace view aff_penalite as
  SELECT
      p.id_penalite,
      p.id_etapes,
      e.nom AS etape_nom,
      e.longuer,
      e.nb_coureur_equipe,
      e.rang_etape,
      e.datedepart,
      e.date_heure_depart,
      p.id_equipe,
      eq.nom AS equipe_nom,
      p.temps
  FROM
      penalite p
          JOIN
      etape e ON p.id_etapes = e.id
          JOIN
      equipe eq ON p.id_equipe = eq.id;
-- affiche genre
 create  or replace view v_genre  as
         select  g.ide,g.nom,c.genre,g.cla,g.temp_effectuer_hh,g.temps,g.temp_penaliter_plus
             from v_classement_equipe_p g
         join coureur c on  g.idc = c.id;

create or replace view test as
  select *
  from  v_calcul join
  calcul c;
