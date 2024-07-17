<?php

// 3

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

// If the form was not submitted or not filled out correctly set the values to ''
if ($_POST) {
    $accession_number = $_POST['accession_number'];
    $artist           = $_POST['artist'];
    $title            = $_POST['title'];
    $medium           = $_POST['medium'];
    $year             = $_POST['year'];
    $acuisitionYear   = $_POST['acquisitionYear'];
} else {
    $accession_number = '';
    $artist           = '';
    $title            = '';
    $medium           = '';
    $year             = '';
    $acuisitionYear   = '';
}

$sql = "SELECT * 
        FROM Artworks
        WHERE (
            accession_number LIKE '%$accession_number%' AND
            title LIKE '%$title%' AND
            medium LIKE '%$medium%' AND
            year LIKE '%$year%' AND
            acquisitionYear LIKE '%$acuisitionYear%' 
            )
            LIMIT 15000";

$query = mysqli_query($link, $sql);

if (!$query) {
    echo "Error: " . mysqli_error($link);
    exit;
}            

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Artist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tufte-css/1.8.0/tufte.min.css">
    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: auto;
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
        }

        input[type="text"] {
            flex: 1;
        }

        input[type="submit"] {
            align-self: flex-start;
        }
    </style>
</head>

<body>
    <button onclick="window.location.href='index.html'">Back to Home</button>
    <h1>Search Artist</h1>

    <form action="searchArtwork.php" method="POST">
        <fieldset>
            <label>Accession Number:</label>
            <input type="text" name="accession_number" value="<?php echo htmlspecialchars($accession_number); ?>" autofocus>
        </fieldset>

        <fieldset>
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
        </fieldset>

        <fieldset>
            <label>Medium:</label>
            <input type="text" name="medium" value="<?php echo htmlspecialchars($medium); ?>">
        </fieldset>

        <fieldset>
            <label>Year:</label>
            <input type="text" name="year" value="<?php echo htmlspecialchars($year); ?>">
        </fieldset>

        <fieldset>
            <label>Acquisition Year:</label>
            <input type="text" name="acquisitionYear" value="<?php echo htmlspecialchars($acuisitionYear); ?>">
        </fieldset>

        <input type="submit" value="Search" />
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Accession Number</th>
                <th>Artist</th>
                <th>Title</th>
                <th>Medium</th>
                <th>Credits</th>
                <th>Year</th>
                <th>Acquisition Year</th>
                <th>Types</th>
                <th>Width</th>
                <th>Height</th>
                <th>Depth</th>
                <th>Units</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['accession_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['artist']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['medium']); ?></td>
                    <td><?php echo htmlspecialchars($row['creditLine']); ?></td>
                    <td><?php echo htmlspecialchars($row['year']); ?></td>
                    <td><?php echo htmlspecialchars($row['acquisitionYear']); ?></td>
                    <td><?php echo htmlspecialchars($row['types']); ?></td>
                    <td><?php echo htmlspecialchars($row['width']); ?></td>
                    <td><?php echo htmlspecialchars($row['height']); ?></td>
                    <td><?php echo htmlspecialchars($row['depth']); ?></td>
                    <td><?php echo htmlspecialchars($row['unnits']); ?></td>
                    <td><a href="<?php echo htmlspecialchars($row['url']); ?>"><?php echo htmlspecialchars($row['url']); ?></a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php mysqli_close($link) ?>
</body>

</html>