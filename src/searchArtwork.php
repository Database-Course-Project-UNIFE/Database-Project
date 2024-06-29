<?php

// 3

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

// If the form was not submitted or not filled out correctly set the values to ''
if ($_POST) {
    $accession_number = $_POST['accession_number'];
    $artist           = $_POST['artist'];
    $title            = $_POST['title'];
    $medium           = $_POST['medium'];
    $year             = $_POST['year'];
} else {
    $accession_number = '';
    $artist           = '';
    $title            = '';
    $medium           = '';
    $year             = '';
}

$sql = "SELECT * 
        FROM Artworks
        WHERE (
            accession_number LIKE $accession_number% AND
            title LIKE $title% AND
            medium LIKE $medium% AND
            year LIKE $year%";

$query = mysqli_query($link, $sql);

if (!$query) {
    echo "Error: " . mysqli_error($link);
    exit;
}            

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Artist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tufte-css/1.8.0/tufte.min.css">
    <style>
        body {
            max-width: 1200px;
        }
    </style>
</head>

<body>
    <button onclick="window.location.href='index.html'">Back to Home</button>

    <h1>Search Artist</h1>

    <form action="searchArtwork.php" method="POST">
        <fieldset>
            <label>Accession Number:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($accession_number); ?>" autofocus>
        </fieldset>

        <fieldset>
            <label>Title:</label>
            <input type="text" name="placeOfDeath" value="<?php echo htmlspecialchars($title); ?>">
        </fieldset>

        <fieldset>
            <label>Medium:</label>
            <input type="text" name="placeOfDeath" value="<?php echo htmlspecialchars($medium); ?>">
        </fieldset>

        <fieldset>
            <label>Year:</label>
            <input type="text" name="placeOfDeath" value="<?php echo htmlspecialchars($year); ?>">
        </fieldset>
    </form>

    <table>
        <thead>
            <tr>
                <th>Accession Number</th>
                <th>Title</th>
                <th>Medium</th>
                <th>Year</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['accession_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['medium']); ?></td>
                    <td><?php echo htmlspecialchars($row['year']); ?></td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php mysqli_close($link) ?>
</body>

</html>