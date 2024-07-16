CREATE SCHEMA IF NOT EXISTS Museo;

USE Museo;

-- Create Artists table
CREATE TABLE Artists (
	id INTEGER NOT NULL,
    name VARCHAR(255) NOT NULL,
    gender CHAR NOT NULL,
    yearOfBirth CHAR(4) NOT NULL,
    birthCity VARCHAR(50) NOT NULL,
    birthState VARCHAR(50) NOT NULL,
    yearOfDeath VARCHAR(4),
    deathCity VARCHAR(50),
    deathState VARCHAR(50),
    url VARCHAR(255) NOT NULL,
    
    PRIMARY KEY (id)
);

-- Create Artworks table
CREATE TABLE Artworks (
    id INTEGER NOT NULL,
    accession_number CHAR(7) NOT NULL,
    artist VARCHAR(255),
    artistRole VARCHAR(100),
    artistId INTEGER NOT NULL,
    title VARCHAR(2047),
    dateText VARCHAR(255),
    medium VARCHAR(255),
    creditLine VARCHAR(2047),
    year INTEGER,
    acquisitionYear INTEGER,
    types VARCHAR(100),
    width INTEGER,
    height INTEGER,
    depth INTEGER,
    units CHAR(2),
    inscription CHAR(15),
    thumbnailUrl VARCHAR(255),
    url VARCHAR(255),
    
    PRIMARY KEY (id),
    FOREIGN KEY (artistId) REFERENCES Artists(id)
);