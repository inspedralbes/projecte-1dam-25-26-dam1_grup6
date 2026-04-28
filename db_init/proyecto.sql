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
    prioritat ENUM('baja', 'media', 'alta'),
    idTecnic INT,
    idDepartament INT,
    idTipologia INT,
    FOREIGN KEY (idTecnic) REFERENCES TECNIC(idTecnic),
    FOREIGN KEY (idDepartament) REFERENCES DEPARTAMENT(idDepartament),
    FOREIGN KEY (idTipologia)db_data6 REFERENCES TIPOLOGIA(idTipologia)
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
