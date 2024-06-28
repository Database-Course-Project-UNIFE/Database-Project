CREATE SCHEMA IF NOT EXISTS Museo;

USE Museo;

-- Create Artists table
CREATE TABLE Artists (
	id INTEGER NOT NULL,
    name VARCHAR(255) NOT NULL,
    gender CHAR NOT NULL,
    yearOfBirth CHAR(4) NOT NULL,
    yearOfDeath VARCHAR(4),
    placeOfBirth VARCHAR(50),
    placeOfDeath VARCHAR(50),
    url VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Create Artworks table
CREATE TABLE Artworks (
	id INTEGER NOT NULL,
    accession_number CHAR(6) NOT NULL,
    artist VARCHAR(100),
    artistRole VARCHAR(20),
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
    depth DECIMAL(10,2),
    units CHAR(2),
    inscription VARCHAR(255),
    thumbnailCopyright VARCHAR(2047),
    thumbnailUrl VARCHAR(255),
    url VARCHAR(255),
    PRIMARY KEY (id)
);