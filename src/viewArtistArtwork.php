<?php

// 2

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

$sql = "SELECT *
        FROM Artworks
        JOIN Artists ON Artworks.artistId = Artists.id
        WHERE (Artworks.artistId={$_GET['artistId']}) 
        ORDER BY Artworks.year ASC";

$query = mysqli_query($link, $sql);
$totalWorks = mysqli_num_rows($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo htmlspecialchars($_GET['artistName']); ?>'s Artworks </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tufte-css/1.8.0/tufte.min.css">
</head>

<body>
    <button onclick="window.location.href='index.html'">Back to Home</button>
    <h1> <?php echo htmlspecialchars($_GET['artistName']); ?>'s Artworks </h1>

    <p>Number of artworks: <?php echo $totalWorks; ?></p>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Accession Number</th>
                <th>Title</th>
                <th>Artist</th>
                <th>Year</th>
                <th>Acquisition Year</th>
                <th>Medium</th>
                <th>Types</th>
                <th>Width</th>
                <th>Height</th>
                <th>Depth</th>
                <th>Unit</th>
                <th>Credits</th>
                <th>URL</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['accession_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['artist']); ?></td>
                    <td><?php echo htmlspecialchars($row['year']); ?></td>
                    <td><?php echo htmlspecialchars($row['acquisitionYear']); ?></td>
                    <td><?php echo htmlspecialchars($row['medium']); ?></td>
                    <td><?php echo htmlspecialchars($row['types']); ?></td>
                    <td><?php echo htmlspecialchars($row['width']); ?></td>
                    <td><?php echo htmlspecialchars($row['height']); ?></td>
                    <td><?php echo htmlspecialchars($row['depth']); ?></td>
                    <td><?php echo htmlspecialchars($row['units']); ?></td>
                    <td><?php echo htmlspecialchars($row['creditLine']); ?></td>
                    <td><a href="<?php echo htmlspecialchars($row['url']); ?>"><?php echo htmlspecialchars($row['url']); ?></a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php mysqli_close($link); ?>
</body>

</html>