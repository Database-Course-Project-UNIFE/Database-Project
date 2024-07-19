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

// 1. number of artwork created in a specific year
if ($_POST) {
    $year   = $_POST['year'];
    $sql1   = "SELECT COUNT(*)
               FROM Artworks
               WHERE (year = '$year')";
    $query1 = mysqli_query($link, $sql1);
} else {
    $year = $query1 = '';
}

// 2. number of artist born or died in a specific nation
if ($_POST) {
    $nation = $_POST['nation'];
    $sql2   = "SELECT COUNT(*)
               FROM Artists
               WHERE (birthState = '$nation' OR deathState = '$nation')";
    $query2 = mysqli_query($link, $sql2);
} else {
    $nation = $query2 = '';
}

// Artists who published their fist artwork under age 18
$sql3          = "SELECT at.id, at.name, at.yearOfBirth
                  FROM Artists at
                  JOIN Artworks aw ON at.id = aw.artistId
                  GROUP BY at.id, at.name, at.yearOfBirth
                  HAVING (MIN(CONVERT(aw.year, SIGNED)) - CONVERT(at.yearOfBirth, SIGNED)) < 18
                          AND MIN(CONVERT(aw.year, SIGNED)) > 0
                  ORDER BY at.name";
$query3        = mysqli_query($link, $sql3);
$numRowsQuery3 = mysqli_num_rows($query3);

// Artist who varied more types of works
$sql4                  = "SELECT at.name, COUNT(DISTINCT aw.medium) AS differentMediums
                          FROM Artists at
                          JOIN Artworks aw ON at.id = aw.artistId
                          GROUP BY at.id, at.name
                          ORDER BY differentMediums DESC
                          LIMIT 1";
$query4                = mysqli_query($link, $sql4);
$resultQuer4           = mysqli_fetch_assoc($query4);
$MoreMediumsArtistName = $resultQuer4['name'];
$differentMediums      = $resultQuer4['differentMediums'];

// Largest and smaller artwork of a specific artist
if ($_POST) {
    $MaxMinArtistName  = $_POST['name'];
    $sql5      = "SELECT aw.title, aw.units, aw.width * aw.height AS area
                 FROM Artworks aw
                 JOIN Artists at ON aw.artistId = at.id
                 WHERE at.name = '$MaxMinArtistName' 
                       AND aw.width IS NOT NULL 
                       AND aw.height IS NOT NULL
                       AND aw.units IS NOT NULL
                       AND aw.title IS NOT NULL
                       AND (aw.width * aw.height) > 0
                 ORDER BY area ASC
                 LIMIT 1";

    $resultMin = mysqli_query($link, $sql5);
    $rowMin    = mysqli_fetch_assoc($resultMin);
    $minArea   = $rowMin['area'];
    $minTitle  = $rowMin['title'];
    $minUnits  = $rowMin['units'];

    $sql5 = str_replace('ASC', 'DESC', $sql5);
    
    $resultMax = mysqli_query($link, $sql5);
    $rowMax    = mysqli_fetch_assoc($resultMax);
    $maxArea   = $rowMax['area'];
    $maxTitle  = $rowMax['title'];
    $maxUnits  = $rowMax['units'];
} else {
    $MaxMinArtistName = $minArea = $minTitle = $minUnits = $maxArea = $maxTitle = $maxUnits = '';
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tufte-css/1.8.0/tufte.min.css">
    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: 0;
            padding-left: 30px;
        }

        fieldset {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border: none;
            padding: 0;
        }

        label {
            width: 150px;
            text-align: left;
            margin-right: 10px;
            font-size: 25px;
        }

        input[type="text"], select {
            flex: 1;
        }

        input[type="submit"] {
            align-self: flex-start;
            margin-top: 10px;
        }
        ul {
            padding-left: 50px; 
        }
    </style>
</head>

<body>
    <button onclick="window.location.href='index.html'">Back to Home</button>
    <h1>Search Artist</h1>

    <h2>Number of artwork created in a specific year: <?php if ($query1) echo mysqli_fetch_assoc($query1)['COUNT(*)']; ?> </h2>
    <form action="stats.php" method="POST">
        <fieldset>
            <label>Year:</label>
            <input type="text" name="year" value="<?php echo htmlspecialchars($year); ?>" autofocus>
        </fieldset>
        <input type="submit" value="Search" />
    </form>

    <h2>Number of artist born or died in a specific nation: <?php if ($query2) echo mysqli_fetch_assoc($query2)['COUNT(*)']; ?> </h2>
    <form action="stats.php" method="POST">
        <fieldset>
            <label>Nation:</label>
            <input type="text" name="nation" value="<?php echo htmlspecialchars($nation); ?>">
        </fieldset>
        <input type="submit" value="Search" />
    </form>

    <h2>Artists who published their fist artwork under age 18: <?php if ($query3) echo $numRowsQuery3; ?></h2>

    <h2>Artist who varied more types of artworks: <?php if ($query4) echo $MoreMediumsArtistName . " (" . $differentMediums . " types)"; ?></h2>

    <h2>Largest and smallest artwork of a specific artist:</h2>
    <form action="stats.php" method="POST">
        <fieldset>
            <label>Artist's name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($MaxMinArtistName); ?>">
        </fieldset>
        <input type="submit" value="Search" />
    </form> 
    <ul>
        <li>Largest:  <?php if ($resultMax) echo $maxTitle . " (" . $maxArea . " " . $maxUnits .  ")"; ?></li>
        <li>Smallest: <?php if ($resultMin) echo $minTitle . " (" . $minArea . " " . $minUnits .  ")"; ?></li>
    </ul>


</body>

</html>