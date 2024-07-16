<?php

$hostname   = "172.25.3.54";
$username   = "nicola";
$password   = "password";
$dbName     = "Museo";

// Connect to the database
$link = mysqli_connect($hostname, $username, $password, $dbName);

// Verify connection
if (!$link) {
    echo "Error: Impossible to connect to the database <br/>";
    echo "Error code: " . mysqli_connect_errno() . "<br/>";
    echo "Error msg: " . mysqli_connect_error() . "<br/>";
    exit;
}

// Function to insert Artists data
function insertArtist($link) {
    $file_path = "/mnt/c/Users/nicol/OneDrive/Documenti/GitHub/Database-Project/csv-files/cleaned_artist_data.csv";
    $file = fopen($file_path, "r");
    
    fgetcsv($file);

    // Prepare the statement
    $stmt = mysqli_prepare($link, "INSERT INTO Artists (id, name, gender, yearOfBirth, birthCity, birthState, yearOfDeath, deathCity, deathState, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "isssssssss", $id, $name, $gender, $yearOfBirth, $birthCity, $birthState, $yearOfDeath, $deathCity, $deathState, $url);

    while (($row = fgetcsv($file)) !== FALSE) {
        // Assign variables from CSV row
        list($id, $name, $gender, $yearOfBirth, $birthCity, $birthState, $yearOfDeath, $deathCity, $deathState, $url) = $row;

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Check for errors
        if (mysqli_stmt_errno($stmt)) {
            echo "Error: " . mysqli_stmt_error($stmt);
            exit;
        }
    }

    fclose($file);
    mysqli_stmt_close($stmt);
}

// Function to insert Artworks data
function insertArtworks($link) {
    $file_path = "/mnt/c/Users/nicol/OneDrive/Documenti/GitHub/Database-Project/csv-files/cleaned_artwork_data.csv";
    $file = fopen($file_path, "r");

    fgetcsv($file);

    // Prepare the statement
    $stmt = mysqli_prepare($link, "INSERT INTO Artworks (id, accession_number, artist, artistRole, artistId, title, dateText, medium, creditLine, year, acquisitionYear, types, width, height, depth, units, inscription, thumbnailUrl, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "isssissssiisiiissss", $id, $accession_number, $artist, $artistRole, $artistId, $title, $dateText, $medium, $creditLine, $year, $acquisitionYear, $types, $width, $height, $depth, $units, $inscription, $thumbnailUrl, $url);

    while (($row = fgetcsv($file)) !== FALSE) {
        // Assign variables from CSV row
        list($id, $accession_number, $artist, $artistRole, $artistId, $title, $dateText, $medium, $creditLine, $year, $acquisitionYear, $types, $width, $height, $depth, $units, $inscription, $thumbnailUrl, $url) = $row;

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Check for errors
        if (mysqli_stmt_errno($stmt)) {
            echo "Error: " . mysqli_stmt_error($stmt);
            exit;
        }
    }

    fclose($file);
    mysqli_stmt_close($stmt);
}

// Data insert
insertArtist($link);
insertArtworks($link);

// Close database connection
mysqli_close($link);

?>