<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "csokas3a";
$password = "csokas3a";
$dbname = "csokas3a";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT id FROM t_user";

$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $_SESSION['id'] = $row['id'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <link rel="stylesheet" href="style.css">
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
            justify-content: center;
        }

        .sort-buttons button:hover {
            background-color: #606469;
        }

        .search-form {
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
        select[name="category"] option:hover{
            color:white;
            background-color: #2F3030;
        }
        select[name="category"] {
            appearance: none; 
            padding: 10px; 
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            color: #333; 
            font-size: 16px; 
            width: 100%; 
            text-align:center;
        }
        select[name="category"] option {
            padding: 10px; 
            background-color: #2F3030; 
            color: white; 
            font-size: 16px; 
        }
        select[name="category"] option[selected] {
            background-color: #f2f2f2;
        }
        .buttons{
            align-items: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
<header>
    <?php include 'navbar.php';?>
</header>
<div class="sort-buttons">
    <form method="get" action="">
        <div class="buttons">
            <input type="hidden" name="order" value="<?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? 'DESC' : 'ASC'; ?>">
            <button type="submit" name="sort" value="najazdene_km">Triedit podla km</button>
            <button type="submit" name="sort" value="rok_vyroby">Triedit podla roku vydania</button>
            <button type="submit" name="sort" value="model_auta">Triedit podla nazvu</button>
        </div>
        <select name="category" onchange="this.form.submit()">
            <option value="">Všetky kategórie</option>
            <?php
            $sql_categories = "SELECT id, typ_auta FROM kategoria";
            $result_categories = $connection->query($sql_categories);

            if ($result_categories->num_rows > 0) {
                while ($row = $result_categories->fetch_assoc()) {
                    $selected = ($_GET['category'] ?? '') == $row['id'] ? 'selected' : '';
                    echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['typ_auta'].'</option>';
                }
            }
            ?>
        </select>
    </form>
</div>

<div class="search-form">
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
</div>

<section class="car-listing">
    <?php
    $sql = "SELECT auto.*, kategoria.typ_auta FROM auto INNER JOIN kategoria ON auto.typ_auta = kategoria.id";

    if (isset($_GET['category']) && $_GET['category'] != '') {
        $category = $_GET['category'];
        $sql .= " WHERE auto.typ_auta = $category";
    }

    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        $order = $_GET['order'] ?? 'ASC';
        $sql .= " ORDER BY $sort $order";
    }

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];
        $sql .= " AND (model_auta LIKE '%$search%' OR vyrobca LIKE '%$search%')";
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
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="car_id" value="'.$row["id"].'">';
            echo '<input type="hidden" name="user_id" value="'.$_SESSION['id'].'">'; 
            echo '<button type="submit" class="buy-button">Buy Now</button>';
            echo '</form>';
            echo '</div>';
        }
    } 
    else {
        echo "No results found";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission
        if(isset($_POST['car_id']) && isset($_POST['user_id'])) {
            $car_id = $_POST['car_id'];
            $user_id = $_POST['user_id'];
            
            $sql = "INSERT INTO
            kosik (id_user, id_auto) VALUES ('$user_id', '$car_id')";
            
            if ($connection->query($sql) === FALSE) {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
        }
    }

    $sql_aggregate = "SELECT COUNT(*) AS count_products,
                      MIN(cena) AS min_price,
                      MAX(cena) AS max_price,
                      AVG(rok_vyroby) AS avg_year,
                      SUM(najazdene_km) AS sum_km
                      FROM auto";

    $result_aggregate = $connection->query($sql_aggregate);

    if ($result_aggregate->num_rows > 0) {
        while ($row = $result_aggregate->fetch_assoc()) {
            $count_products = $row['count_products'];
            $min_price = $row['min_price'];
            $max_price = $row['max_price'];
            $avg_year = $row['avg_year'];
            $sum_km = $row['sum_km'];
        } 
    } 
    else {
        echo "No results found";
    }

    $connection->close();
    ?>
</section>

<div class="stats">
    <?php
        echo "<p>Počet áut: $count_products</p>";
        echo "<p>Minimálna cena: $min_price €</p>";
        echo "<p>Maximálna cena: $max_price €</p>";
        echo "<p>Priemerný rok vydania: $avg_year</p>";
        echo "<p>Spočítané kilometre áut: $sum_km km</p>";
    ?>
</div>
</body>
</html>