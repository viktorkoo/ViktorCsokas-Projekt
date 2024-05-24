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
<header>
    <?php include 'navbar.php';?>
</header>
<div class="sort-buttons">
    <form method="get" action="">
        <input type="hidden" name="order" value="<?php echo ($_GET['order'] ?? 'ASC') === 'ASC' ? 'DESC' : 'ASC'; ?>">
        <button type="submit" name="sort" value="najazdene_km">Triedit podla km</button>
        <button type="submit" name="sort" value="id">Triedit podla ID</button>
        <button type="submit" name="sort" value="model_auta">Triedit podla nazvu</button>
        <select name="category" onchange="this.form.submit()">
            <option value="">Všetky kategórie</option>
            <?php
            $servername = "localhost";
            $username = "csokas3a";
            $password = "csokas3a";
            $dbname = "csokas3a";

            $connection = new mysqli($servername, $username, $password, $dbname);

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

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
    } 
    else {
        echo "No results found";
    }

    // Additional query within the same PHP block
    $sql_aggregate = "SELECT COUNT(*) AS count_products,
    MIN(cena) AS min_price,
    MAX(cena) AS max_price,
    AVG(rok_vyroby) AS avg_year,
    SUM(najazdene_km) AS sum_km
    FROM auto";

    $result_aggregate = $connection->query($sql_aggregate);

    if ($result_aggregate->num_rows > 0) {
        while ($row = $result_aggregate->fetch_assoc()) {
            // Store the values for later use
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
        echo "<p>Počet produktov: $count_products</p>";
        echo "<p>Minimálna cena: $min_price €</p>";
        echo "<p>Maximálna cena: $max_price €</p>";
        echo "<p>Priemerný rok vydania: $avg_year</p>";
        echo "<p>Spočítané kilometre áut: $sum_km km</p>";
    ?>
</div>
</body>
</html>
