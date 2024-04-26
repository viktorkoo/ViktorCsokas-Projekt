<?php

$servername = "localhost";
$username = "csokas3a";
$password = "csokas3a";
$dbname = "csokas3a";



$connection = new mysqli($servername, $username, $password, $dbname);

//skontrolujem pripojenie
if ($connection->connect_error) {
    die("Chyba pripojenie k db: " . $connection->connect_error);
}

$sql = "SELECT * FROM auto" ;

$vysledok = $connection->query($sql);

$pocet = $vysledok->num_rows;

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    if(isset($_POST['car_id']) && isset($_POST['user_id'])) {
        $car_id = $_POST['car_id'];
        $user_id = $_POST['user_id'];
        
        // Prepare SQL statement to insert into database
        $sql = "INSERT INTO kosik (id_user, id_auto) VALUES ('$user_id', '$car_id')";
        
        if ($connection->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }
}*/

?>
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


    </style>
</head>
<body>
<section class="car-listing">
  <?php
  if($pocet<=0){
    echo "Prazdna databaza";
}

if ($pocet>0){
    while($riadok = $vysledok->fetch_assoc() ){
        echo '<div class="car">';
        echo '<img src="'.$riadok["fotka"].'">';
        echo '<h2>'.$riadok["model_auta"].'</h2>';
        echo '<h3>'.$riadok["vyrobca"].'</h3>';
        echo '<p>Cena: '.$riadok["cena"].' €</p>';
        echo '<p>Najazdené km: '.$riadok["najazdene_km"].' km</p>';
        echo '<p>Rok výroby: '.$riadok["rok_vyroby"].'</p>';
        echo '<p>'.$riadok["typ_auta"].'</p>';
        echo '<form method="post" action="">'; 
        echo '<input type="hidden" name="car_id" value="'.$riadok["id"].'">';
        echo '<input type="hidden" name="user_id" value="1">'; 
        //echo '<button type="submit" class="buy-button">Buy Now</button>';
        echo '</form>';
        echo '</div>';
    }
}
  ?>
</section>
</body>
</html>