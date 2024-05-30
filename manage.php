<?php
session_start();

$servername = "localhost";
$dbname = "csokas3a";
$dbusername = "csokas3a";
$dbpassword = "csokas3a";


$connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $model = $_POST['model'];
    $vyrobca = $_POST['vyrobca'];
    $rok = $_POST['rok'];
    $km = $_POST['km'];
    $typ = $_POST['typ'];
    $cena = $_POST['cena'];
    $meno_fotka = $_POST['meno_fotka'];
    $photo = $_FILES['fotka'];

    $target_dir = "img/";
    $target_file = $target_dir . basename($photo["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an actual image
    $check = getimagesize($photo["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($photo["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
        echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($photo["tmp_name"], $target_file)) {
            $stmt = $connection->prepare("INSERT INTO auto (model_auta, vyrobca, rok_vyroby, najazdene_km, typ_auta, cena, fotka) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiiiss", $model, $vyrobca, $rok, $km, $typ, $cena, $meno_fotka);
            if ($stmt->execute()) {
                echo "New record created successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $connection->prepare("DELETE FROM auto WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin</title>
    <style>
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: blue;
            color: white;
            cursor: pointer;
            padding: 10px;
            border: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<header>
    <?php include 'navbar.php'; ?>
</header>
<div class="edit">
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="insert" value="1">
    <label for="model">Model auta: </label>
    <input type="text" id="model" name="model" required>

    <label for="vyrobca">Vyrobca: </label>
    <input type="text" id="vyrobca" name="vyrobca" required>

    <label for="rok">Rok vyroby: </label>
    <input type="number" id="rok" name="rok" required>

    <label for="km">Najazdene km:</label>
    <input type="number" id="km" name="km" required>

    <label for="typ">Typ auta:</label>
    <input type="text" id="typ" name="typ" required>

    <label for="cena">Cena: </label>
    <input type="number" id="cena" name="cena" required>
    
    <label for="meno_fotka">Umiestnenie suboru/nazovsuboru.filetype:</label>
    <input type="text" id="meno_fotka" name="meno_fotka" required>

    <label for="fotka">Fotka:</label>
    <input type="file" id="fotka" name="fotka" accept="image/*" required>

    <input type="submit" value="Insert">
</form>

<form action="" method="post">
    <input type="hidden" name="delete" value="1">
    <label for="id">ID auta na zmazanie: </label>
    <input type="number" id="id" name="id" required>

    <input type="submit" value="Delete">
</form>
</div>
<section class="car-listing">
    <?php
    $connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "SELECT auto.*, kategoria.typ_auta FROM auto INNER JOIN kategoria ON auto.typ_auta = kategoria.id";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="car">';
            echo '<img src="'.$row["fotka"].'" alt="'.$row["model_auta"].'">';
            echo '<h2>'.$row["model_auta"].'</h2>';
            echo "ID: ".'<h2>'.$row["id"].'</h2>';
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
