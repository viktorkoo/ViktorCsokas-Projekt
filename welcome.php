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
            margin: 0;
            flex-direction: column;
        }

        img {
            height: 200px;
            aspect-ratio: 16/10;
        }

        .sort-buttons {
            margin-bottom: 20px;
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .sort-buttons button {
            padding: 10px 20px;
            margin: 0 5px;
            background-color: #3b3d40;
            color: #ffff; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }

        .sort-buttons button:hover {
            background-color: #606469;
        }
    </style>
</head>
<body>
<div class="sort-buttons">
    <form method="get" action="">
        <button type="submit" name="sort" value="najazdene_km">Triedit podla km</button>
        <button type="submit" name="sort" value="id">Triedit podla ID</button>
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

    $valid_sort_columns = ['najazdene_km', 'id', 'model_auta'];
    $sort_by = isset($_GET['sort']) && in_array($_GET['sort'], $valid_sort_columns) ? $_GET['sort'] : 'id';
    $sql = "SELECT auto.*, kategoria.typ_auta FROM auto INNER JOIN kategoria ON auto.typ_auta=kategoria.id ORDER BY $sort_by";

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
