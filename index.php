<?php

$servername = "localhost";
$username = "csokas3a";
$password = "csokas3a";
$dbname = "csokas3a";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autickaaa</title>
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
            margin-top: 70px;
            display: flex;
            justify-content: center;
        }
        .stats p {
            margin-left: 2vw;
            margin-right: 2vw;
            display: flex;
            justify-content: center;
            display:inline-block;
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

        .search-form {
            margin-top: 20px;
            text-align: center;
        }

        .search-form input[type="text"] {
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .search-form button {
            padding: 8px 20px;
            background-color: #3b3d40;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-form button:hover {
            background-color: #606469;
        }
    </style>
</head>

<body>
<header>
    <?php include 'navbar.php';?>
</header>
<h1 style="text-align:center;">Pre kúpu auta a na odomknutie všetkých funkcií sa <a href="login.php">Prihláste</a>, alebo sa <a href="register.php">Zaregistrujte</a></h1>
<section class="car-listing">
    <?php
    $sql = "SELECT auto.*, kategoria.typ_auta FROM auto INNER JOIN kategoria ON auto.typ_auta = kategoria.id";

    if (isset($_GET['category']) && $_GET['category'] != '') {
        $category = $_GET['category'];
        $sql .= " WHERE auto.typ_auta = $category";
    }

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
            echo '</form>';
            echo '</div>';
        }
    } 
    else {
        echo "No results found";
    }
    ?>
</section>
</body>
</html>