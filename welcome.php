<!DOCTYPE html>
<html lang="en">
<head>
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
<?php

$servername = "localhost";
$username = "csokas3a";
$password = "csokas3a";
$dbname = "csokas3a";

$connection = new mysqli($servername, $username, $password, $dbname);


if ($connection->connect_error) {
    die("Chyba pripojenie k db: " . $connection->connect_error);
}

$sql = "SELECT id, nazov FROM t_produkt";

$vysledok = $connection->query($sql);

$pocet = $vysledok->num_rows;

if ($pocet>0){
    while($riadok = $vysledok->fetch_assoc() ){
        echo "Produkt ".$riadok["id"]." je: " .$riadok["nazov"]." <br />";
    }
}
?> 
</body>
</html>