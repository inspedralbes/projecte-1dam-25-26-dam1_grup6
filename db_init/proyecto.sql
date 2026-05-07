SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS proyecto
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

GRANT ALL PRIVILEGES ON proyecto.* TO 'usuari'@'%';
FLUSH PRIVILEGES;

USE proyecto;


CREATE TABLE DEPARTAMENT(
    idDepartament INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE TECNIC(
    idTecnic INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE TIPOLOGIA(
    idTipologia INT AUTO_INCREMENT PRIMARY KEY,
    nomTipologia VARCHAR(100)
);

CREATE TABLE INCIDENCIA(
    idIncidencia INT AUTO_INCREMENT PRIMARY KEY,
    descripcio VARCHAR(2000),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    dataFinalitzacio DATE,
    idTecnic INT,
    prioritat ENUM('baja', 'media', 'alta'),
    idDepartament INT,
    idTipologia INT,
    FOREIGN KEY (idTecnic) REFERENCES TECNIC(idTecnic),
    FOREIGN KEY (idDepartament) REFERENCES DEPARTAMENT(idDepartament),
    FOREIGN KEY (idTipologia) REFERENCES TIPOLOGIA(idTipologia)
);

CREATE TABLE ACTUACIO(
    idActuacion INT AUTO_INCREMENT PRIMARY KEY,
    descripcio VARCHAR(1000) NOT NULL,
    visible INT(1) NOT NULL,
    fecha TIMESTAMP,
    temps INT NOT NULL,
    idIncidencia INT,
    FOREIGN KEY (idIncidencia) REFERENCES INCIDENCIA(idIncidencia)
);


INSERT INTO DEPARTAMENT (nom) VALUES ('Mates');
INSERT INTO DEPARTAMENT (nom) VALUES ('Fisica');
INSERT INTO DEPARTAMENT (nom) VALUES ('Quimica');
INSERT INTO DEPARTAMENT (nom) VALUES ('Lengua');
INSERT INTO DEPARTAMENT (nom) VALUES ('Informatica');


INSERT INTO TECNIC (nom) VALUES ('Juan');
INSERT INTO TECNIC (nom) VALUES ('Alex');
INSERT INTO TECNIC (nom) VALUES ('Luis');


INSERT INTO TIPOLOGIA (nomTipologia) VALUES ('Red');
INSERT INTO TIPOLOGIA (nomTipologia) VALUES ('Hardware');
INSERT INTO TIPOLOGIA (nomTipologia) VALUES ('Software');
INSERT INTO TIPOLOGIA (nomTipologia) VALUES ('Consumibles');

CREATE OR REPLACE VIEW vista_informe_tecnics AS

SELECT

    t.idTecnic,

    t.nom AS nomTecnic,

    i.prioritat,

    i.idIncidencia,

    i.descripcio AS descripcioIncidencia,

    i.fecha AS dataInici,

    IFNULL(SUM(a.temps), 0) AS tempsTotalDedicat

FROM TECNIC t

INNER JOIN INCIDENCIA i

    ON t.idTecnic = i.idTecnic

LEFT JOIN ACTUACIO a

    ON i.idIncidencia = a.idIncidencia

WHERE i.dataFinalitzacio IS NULL

GROUP BY

    t.idTecnic,

    t.nom,

    i.prioritat,

    i.idIncidencia,

    i.descripcio,

    i.fecha

CREATE OR REPLACE VIEW vista_consum_departaments AS

SELECT

    d.idDepartament,

    d.nom AS nomDepartament,

    COUNT(i.idIncidencia) AS nombreIncidencies,

    IFNULL(SUM(temps_per_incidencia.tempsTotal), 0) AS tempsTotalDedicat

FROM DEPARTAMENT d

LEFT JOIN INCIDENCIA i

    ON d.idDepartament = i.idDepartament

LEFT JOIN (

    SELECT

        incidencia,

        SUM(temps) AS tempsTotal

    FROM ACTUACIO

    GROUP BY incidencia

) AS temps_per_incidencia

    ON i.idIncidencia = temps_per_incidencia.incidencia

GROUP BY

    d.idDepartament,

    d.nom;