<?php

// 1

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

// Verify connection
if (!$link) {
    echo "Error: Impossible to connect to the database <br/>";
    echo "Error code: " . mysqli_connect_errno() . "<br/>";
    echo "Error msg: " . mysqli_connect_error() . "<br/>";
    exit;
}

// If the form was not submitted or not filled out correctly set the values to ''
if ($_POST) {
    $name         = $_POST['name'];
    $gender       = $_POST['gender'];
    $yearOfBirth  = $_POST['yearOfBirth'];
    $yearOfDeath  = $_POST['yearOfDeath'];
    $birthCity    = $_POST['birthCity'];
    $birthState   = $_POST['birthState'];
    $deathCity    = $_POST['deathCity'];
    $deathState   = $_POST['deathState'];
} else {
    $name         = '';
    $gender       = '';
    $yearOfBirth  = '';
    $yeraOfDeath  = '';
    $birthCity    = '';
    $birthState   = '';
    $deathCity    = '';
    $deathState   = '';
}

$sql = "SELECT *
        FROM Artists
        WHERE (
                name LIKE '%$name%' AND 
                gender LIKE '%$gender%' AND 
                yearOfBirth LIKE '%$yearOfBirth%' AND 
                yearOfDeath LIKE '%$yearOfDeath%' AND 
                birthCity LIKE '%$birthCity%' AND
                birthState LIKE '%$birthState%' AND
                deathCity LIKE '%$deathCity%' AND
                deathState LIKE '%$deathState%'
                )";

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
            margin: 0;
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

        input[type="text"], select {
            flex: 1;
        }

        input[type="submit"] {
            align-self: flex-start;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <button onclick="window.location.href='index.html'">Back to Home</button>

    <h1>Search Artist</h1>

    <form action="searchArtist.php" method="POST">
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
            <label>Birth City:</label>
            <input type="text" name="birthCity" value="<?php echo htmlspecialchars($birthCity); ?>">
        </fieldset>

        <fieldset>
            <label>Birth State:</label>
            <input type="text" name="birthState" value="<?php echo htmlspecialchars($birthState); ?>">
        </fieldset>

        <fieldset>
            <label>Death City:</label>
            <input type="text" name="deathCity" value="<?php echo htmlspecialchars($deathCity); ?>">
        </fieldset>

        <fieldset>
            <label>Death State:</label>
            <input type="text" name="deathState" value="<?php echo htmlspecialchars($deathState); ?>">
        </fieldset>

        <input type="submit" value="Search" />

    </form>

        <br>
        <br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Year of Birth</th>
                <th>Year of Death</th>
                <th>Birth City</th>
                <th>Birth State</th>
                <th>Death City</th>
                <th>Death State</th>
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
                    <td><?php echo htmlspecialchars($row['birthCity']); ?></td>
                    <td><?php echo htmlspecialchars($row['birthState']); ?></td>
                    <td><?php echo htmlspecialchars($row['deathCity']); ?></td>
                    <td><?php echo htmlspecialchars($row['deathState']); ?></td>
                    <td><a href="<?php echo htmlspecialchars($row['url']); ?>"><?php echo htmlspecialchars($row['url']); ?></a></td>
                    <td>
                
                    <td><button onclick="window.location.href='viewArtistArtwork.php?artistId=<?php echo htmlspecialchars($row['id']); ?>&artistName=<?php echo htmlspecialchars($row['name']); ?>'">View Artworks</button></td>
            </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <?php mysqli_close($link) ?>
    </body>
    
    </html>