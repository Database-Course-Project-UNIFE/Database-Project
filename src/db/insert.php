<?php

$hostname   = "172.25.3.54";
$username   = "nicola";
$password   = "password";
$dbName     = "Museo";

// Connect to the database
$link = mysqli_connect($hostname, $username, $password, $dbname);

// Verify connection
if (!$link) {
    echo "Error: Impossible to connect to the database <br/>";
    echo "Error code: " . mysqli_connect_errno() . "<br/>";
    echo "Error msg: " . mysqli_connect_error() . "<br/>";
    exit;
}

// Function to insert Artists data
function insertArtist($link) {
    $file = fopen("path/to/cleaned_artist_data.csv", "r");
    
    fgetcsv($file);

    while (($row = fgetcsv($file)) !== FALSE) {
        $id           = $row[0];
        $name         = $row[1];
        $gender       = $row[2];
        $yearOfBirth  = $row[3];
        $yearOfDeath  = $row[4];
        $placeOfBirth = $row[5];
        $placeOfDeath = $row[6];
        $url          = $row[7];

        $sql = "INSERT INTO Artists (id, name, gender, yearOfBirth, yearOfDeath, placeOfBirth, placeOfDeath, url)
                VALUES ('$id', '$name', '$gender', '$yearOfBirth', '$yearOfDeath', '$placeOfBirth', '$placeOfDeath', '$url')";

        $query = mysqli_query($link, $sql);
        if (!$query) {
            echo "Error: " . mysqli_error($link);
            exit;
        }
    }

    fclose($file);
}

// Function to insert Artworks data
function insertArtworks($link) {
    $file = fopen("path/to/cleaned_artwork_data.csv", "r");

    fgetcsv($file);

    while (($row = fgetcsv($file)) !== FALSE) {
        $id                 = $row[0];
        $accession_number   = $row[1];
        $artist             = $row[2];
        $artistRole         = $row[3];
        $artistId           = $row[4];
        $title              = $row[5];
        $dateText           = $row[6];
        $medium             = $row[7];
        $creditLine         = $row[8];
        $year               = $row[9];
        $acquisitionYear    = $row[10];
        $types              = $row[11];
        $width              = $row[12];
        $height             = $row[13];
        $depth              = $row[14];
        $units              = $row[15];
        $inscription        = $row[16];
        $thumbnailCopyright = $row[17];
        $thumbnailUrl       = $row[18];
        $url                = $row[19];
    }

    $sql = "INSERT INTO ARTWORKS (id, accession_number, artist, artistRole, artistId, title, dateText, medium, creditLine, year, acquisitionYear, 
                                  types, width, height, depth, units, inscription, thumbnailCopyright, thumbnailUrl, url)
            VALUES ('$id', '$accession_number', '$artist', '$artistRole', '$artistId', '$title', '$dateText', '$medium', '$creditLine', '$year'
                    '$acquisitionYear', '$types', '$width', '$height', '$depth', '$units', '$inscription', '$thumbnailCopyright', '$thumbnailUrl', '$url')";

    $query = mysqli_query($link, $sql);
    if (!$query) {
        echo "Error: " . mysqli_error($link);
        exit;
    }

    fclose($file);
}

// Data insert
insertArtist($link);
insertArtworks($link);

// Close database connection
mysqli_close($link);

?>