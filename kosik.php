<?php

$servername = "localhost";
$dbname = "csokas3a";
$dbusername = "csokas3a";
$dbpassword = "csokas3a";

session_start();

if(!isset($_SESSION['username'])) {
    echo 'Session not set.';
    header("Location: login.php");
    exit();
}

$connection = new mysqli($servername, $dbname, $dbusername,$dbpassword );

//skontrolujem pripojenie
if ($connection->connect_error) {
    die("Chyba pripojenie k db: " . $connection->connect_error);
}

$sql = "SELECT * FROM auto,kosik,t_user WHERE kosik.id_user = ".$_SESSION['id']." AND auto.id = kosik.id_auto" ;

$vysledok = $connection->query($sql);

$pocet = $vysledok->num_rows;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    if(isset($_POST['car_id'])) {
        $car_id = $_POST['car_id'];
        // Prepare SQL statement to insert into database
        $sql2 = "DELETE FROM kosik WHERE id_auto = '$car_id' ";
        
        
        
        if ($connection->query($sql2) === FALSE) {
            echo "Error: " . $sql2 . "<br>" . $connection->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CarDealerz</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
  <?php include 'navbar.php';?>
</header>

<section class="car-listing">

<?php
    //$sql = "SELECT auto.*, kategoria.typ_auta FROM auto INNER JOIN kategoria ON auto.typ_auta = kategoria.id";
    $sql = "SELECT * FROM kosik 
    INNER JOIN t_user ON kosik.id_user = t_user.id 
    INNER JOIN auto ON auto.id = kosik.id_auto 
    INNER JOIN kategoria ON auto.typ_auta = kategoria.id 
    WHERE kosik.id_user = ".$_SESSION['id'];

        $vysledok = $connection->query($sql);

        $pocet = $vysledok->num_rows;

  if($pocet<=0){
    echo "Prazdna databaza";
}

if ($pocet>0){
    while($riadok = $vysledok->fetch_assoc() ){
        echo '<div class="car">';
        echo '<img src="'.$riadok["fotka"].'" alt="Car 1">';
        echo '<h2>'.$riadok["model_auta"].'</h2>';
        echo '<h3>'.$riadok["vyrobca"].'</h3>';
        echo '<p>Cena: '.$riadok["cena"].' €</p>';
        echo '<p>Najazdené km: '.$riadok["najazdene_km"].' km</p>';
        echo '<p>Rok výroby: '.$riadok["rok_vyroby"].'</p>';
        echo '<p>'.$riadok["typ_auta"].'</p>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="car_id" value="'.$riadok["id_auto"].'">';
        echo '<button type="submit" class="buy-button">Odstranit</button>';
        echo '</form>';
        echo '</div>';
    }
}
?>
</section>

<footer>
  <p>&copy; CarDealerz Car Dealership. All rights reserved.</p>
</footer>

</body>
</html>
