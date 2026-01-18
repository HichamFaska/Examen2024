CREATE DATABASE aideseisme;
USE aideseisme;

CREATE TABLE provinces (
    idProvince INT AUTO_INCREMENT PRIMARY KEY,
    intituleProvince VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE communes (
    idCommune INT AUTO_INCREMENT PRIMARY KEY,
    intituleCommune VARCHAR(100) NOT NULL,
    idProvince INT NOT NULL,
    CONSTRAINT fk_communes_provinces
        FOREIGN KEY (idProvince)
        REFERENCES provinces(idProvince)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;



CREATE TABLE proprietaires (
    cnieProprietaire VARCHAR(20) PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    fonction VARCHAR(100),
    nombrePersonneCharge INT,
    tel VARCHAR(20),
    adresse VARCHAR(255),
    etatMaison TINYINT NOT NULL COMMENT '1=partiellement détruite, 2=totalement détruite',
    idCommune INT NOT NULL,
    CONSTRAINT fk_proprietaires_communes
        FOREIGN KEY (idCommune)
        REFERENCES communes(idCommune)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE admins (
    cnieAdmin VARCHAR(20) PRIMARY KEY,
    nomAdmin VARCHAR(100) NOT NULL,
    prenomAdmin VARCHAR(100) NOT NULL,
    telAdmin VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    idProvince INT NOT NULL,
    CONSTRAINT fk_admins_provinces
        FOREIGN KEY (idProvince)
        REFERENCES provinces(idProvince)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE aideLogements (
    idAideLogement INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    percue BOOLEAN NOT NULL COMMENT '1=argent reçu, 0=argent non reçu',
    cnieProprietaire VARCHAR(20) NOT NULL,
    CONSTRAINT fk_aideLogements_proprietaires
        FOREIGN KEY (cnieProprietaire)
        REFERENCES proprietaires(cnieProprietaire)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

