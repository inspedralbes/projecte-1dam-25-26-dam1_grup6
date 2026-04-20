CREATE TABLE DEPARTAMENT(
    idDepartament INT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE TECNIC(
    idTecnic INT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE TIPOLOGIA(
    idTipologia INT PRIMARY KEY,
    nomTipologia VARCHAR(100)
);

CREATE TABLE INCIDENCIA(
    idIncidencia INT PRIMARY KEY,
    descripcio VARCHAR(2000),
    data TIMESTAMP,
    dataFinalitzacio DATE,
    idTecnic INT,
    idDepartament INT,
    idTipologia INT,
    FOREIGN KEY (idTecnic) REFERENCES TECNIC(idTecnic),
    FOREIGN KEY (idDepartament) REFERENCES DEPARTAMENT(idDepartament),
    FOREIGN KEY (idTipologia) REFERENCES TIPOLOGIA(idTipologia)
);

CREATE TABLE ACTUACIO(
    idActuacion INT PRIMARY KEY,
    descripcio VARCHAR(1000) NOT NULL,
    visible INT(1) NOT NULL,
    data TIMESTAMP,
    temps INT NOT NULL,
    idIncidencia INT,
    FOREIGN KEY (idIncidencia) REFERENCES INCIDENCIA(idIncidencia)
);
