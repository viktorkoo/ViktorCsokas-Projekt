<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .sort-buttons {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="sort-buttons">
        <form method="get" action="">
            <button type="submit" name="sort" value="najazdene_km">Triedit podla km</button>
        </form>
        <form method="get" action="">
            <button type="submit" name="sort" value="id">Triedit podla ID</button>
        </form>
        <form method="get" action="">
            <button type="submit" name="sort" value="model_auta">Triedit podla nazvu</button>
        </form>
    </div>
<section class="car-listing">
    <?php
    $servername = "localhost";
    $username = "csokas3a";
    $password = "csokas3a";
    $dbname = "csokas3a";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'id'; // defaultne zoradenie podľa ID
    $sql = "SELECT * FROM auto ORDER BY $sort_by"; // zmena SELECT s orderBy

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="car">';
            echo '<img src="'.$row["fotka"].'">';
            echo '<h2>'.$row["model_auta"].'</h2>';
            echo '<h3>'.$row["vyrobca"].'</h3>';
            echo '<p>Cena: '.$row["cena"].' €</p>';
            echo '<p>Najazdené km: '.$row["najazdene_km"].' km</p>';
            echo '<p>Rok výroby: '.$row["rok_vyroby"].'</p>';
            echo '<p>'.$row["typ_auta"].'</p>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="car_id" value="'.$row["id"].'">';
            echo '<input type="hidden" name="user_id" value="1">';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "No results found";
    }
    $connection->close();
    ?>
</section>
</body>
</html>
