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

$name         = $_POST['name'];
$gender       = $_POST['gender'];
$yearOfBirth  = $_POST['yearOfBirth'];
$yeraOfDeath  = $_POST['yearOfDeath'];
$placeOfBirth = $_POST['placeOfBirth'];
$placeOfDeath = $_POST['placeOfDeath'];

$sql = "SELECT *
        FROM Artist
        WHERE (
                name LIKE $name% AND 
                gender LIKE $gender% AND 
                yearOfBirth LIKE $yearOfBirth% AND 
                yearOfDeath LIKE $yeraOfDeath% AND 
                placeOfBirth LIKE $placeOfBirth% AND 
                placeOfDeath LIKE $placeOfDeath";

$query = mysqli_query($link, $sql);

if (!$query) {
    echo "Error: " . mysqli_error($link);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Artist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
        body {
            max-width: 1200px;
        }
    </style>
</head>

<body>
    <h1>Ricerca Artisti</h1>

    <form action="get.php" method="POST">
        <fieldset>
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" autofocus>
        </fieldset>

        <fieldset>
            <label>Gender:</label>
            <select name="gender">
                <option value="" <?php echo htmlspecialchars(($gender == "") ? "selected" : ""); ?>>Unselected</option>
                <option value="M" <?php echo htmlspecialchars(($gender == "M") ? "selected" : ""); ?>>Male</option>
                <option value="F" <?php echo htmlspecialchars(($gender == "F") ? "selected" : ""); ?>>Female</option>
            </select>
        </fieldset>

        <fieldset>
            <label>Year of birth:</label>
            <input type="text" name="yearOfBirth" value="<?php echo htmlspecialchars($yearOfBirth); ?>">
        </fieldset>

        <fieldset>
            <label>Year of death:</label>
            <input type="text" name="yearOfDeath" value="<?php echo htmlspecialchars($yearOfDeath); ?>">
        </fieldset>

        <fieldset>
            <label>Place of birth:</label>
            <input type="text" name="placeOfBirth" value="<?php echo htmlspecialchars($placeOfBirth); ?>">
        </fieldset>

        <fieldset>
            <label>Place of death:</label>
            <input type="text" name="placeOfDeath" value="<?php echo htmlspecialchars($placeOfDeath); ?>">
        </fieldset>

    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Year od Birth</th>
                <th>Year of Death</th>
                <th>Place of Birth</th>
                <th>Place of Death</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['yearOfBirth']); ?></td>
                    <td><?php echo htmlspecialchars($row['yearOfDeath']); ?></td>
                    <td><?php echo htmlspecialchars($row['placeOfBirth']); ?></td>
                    <td><?php echo htmlspecialchars($row['placeOfDeath']); ?></td>
                    <td><?php echo htmlspecialchars($row['url']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php mysqli_close($link) ?>
</body>

</html>