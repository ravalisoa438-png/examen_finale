create database if not exists itfood;

use itfood;

create table membre (
  id_membre int AUTO_INCREMENT PRIMARY KEY,
  nom varchar(100),
  numero_etu varchar(100) UNIQUE,
  image_profil varchar(255)
);

create table categorie (
    id_categorie int AUTO_INCREMENT PRIMARY KEY,
    nom_categorie varchar(100)
);

create table produit (
    id_produit int AUTO_INCREMENT PRIMARY KEY,
    nom varchar(100),
    id_categorie int,
    prix_reference int,
    FOREIGN KEY (id_categorie) REFERENCES categorie(id_categorie)
);

create table produit_membre (
    id_produit_membre int AUTO_INCREMENT PRIMARY KEY,
    id_produit int,
    id_membre int,
    prix_vente int,
    quantite_dispo int,
    date_dispo date,
    FOREIGN KEY (id_produit) REFERENCES produit(id_produit),
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);

create table vente (
    id_vente int AUTO_INCREMENT PRIMARY KEY,
    `date` date,
    `heure` time,
    id_produit_membre int,
    quantite int,
    FOREIGN KEY (id_produit_membre) REFERENCES produit_membre(id_produit_membre)
);

insert into membre(nom, numero_etu) values
('Harena','ETU004958'),
('Dolly','ETU005050'),
('Toky','ETU002012'),
('Anderson','ETU005021'),
('Kevin','ETU005858'),
('Biza','ETU004990'),
('Itso','ETU004948'),
('Mitoky','ETU004932'),
('Mamy','ETU003958'),
('Heriniaina','ETU002020');

insert into categorie(nom_categorie) values
('plat'),
('boisson'),
('snack'),
('dessert');

insert into produit(nom, id_categorie, prix_reference) values
('Nems',3,500),
('Coca-cola',2,1000),
('Soupe',1,1500),
('Sambos',3,200),
('Mine-sao',1,5000),
('Yaourt',4,1200),
('Riz-cantonais',1,4000),
('Jus Star',2,1500),
('The glace',2,1000),
('Brochette',3,600),
('Salade de fruit',4,2000),
('CheezeCake',4,1000),
('Frite',1,500),
('Bannane',4,1200),
('Vodka',2,5000);

insert into produit_membre(id_produit, id_membre, prix_vente, quantite_dispo, date_dispo) values
(1,1,600,15,'2026-07-20'),
(2,1,1200,20,'2026-07-20'),
(3,2,1600,10,'2026-07-20'),
(4,2,250,25,'2026-07-20'),
(5,3,5500,8,'2026-07-20'),
(6,3,1300,12,'2026-07-20'),
(7,4,4200,6,'2026-07-21'),
(8,4,1700,10,'2026-07-21'),
(9,5,1100,15,'2026-07-21'),
(10,5,700,20,'2026-07-21'),
(11,6,2200,10,'2026-07-21'),
(12,6,1100,12,'2026-07-22'),
(13,7,600,18,'2026-07-22'),
(14,7,1300,10,'2026-07-22'),
(15,8,5500,5,'2026-07-22'),
(1,9,650,10,'2026-07-22'),
(3,9,1700,8,'2026-07-23'),
(6,10,1400,10,'2026-07-23'),
(9,10,1200,15,'2026-07-23'),
(12,10,1150,10,'2026-07-23');

insert into vente(`date`, `heure`, id_produit_membre, quantite) values
('2026-07-20','12:05:00',1,2),
('2026-07-20','12:10:00',2,1),
('2026-07-20','12:30:00',4,5),
('2026-07-21','13:00:00',7,1),
('2026-07-21','13:15:00',9,3),
('2026-07-21','13:45:00',10,4),
('2026-07-22','12:20:00',13,2),
('2026-07-22','12:40:00',16,1),
('2026-07-23','11:50:00',18,2),
('2026-07-23','12:00:00',20,3);