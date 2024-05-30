<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo '<script>alert("Musis byt prihlaseny na zobrazenie!");</script>';
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $old_password = $_POST['old_password'];
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];
    $new_email = $_POST['email'];
    $new_address = $_POST['address'];
    $current_username = $_SESSION['username'];

    // Fetch the current password from the database
    $stmt = $connection->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $current_username);
    $stmt->execute();
    $stmt->bind_result($current_password_hash);
    $stmt->fetch();
    $stmt->close();

    // Verify the old password
    if (password_verify($old_password, $current_password_hash)) {
        // Hash the new password before saving
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $connection->prepare("UPDATE users SET username=?, password=?, email=?, address=? WHERE username=?");
        $stmt->bind_param("sssss", $new_username, $hashed_password, $new_email, $new_address, $current_username);

        if ($stmt->execute()) {
            echo "Profile updated successfully.";
            $_SESSION['username'] = $new_username; // Update session username
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "The old password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            flex-direction: column;
            height: 100vh;
            background-color: #f2f2f2;
        }
        .edit, .car-listing {
            width: 100%;
            max-width: 800px;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            max-width: 400px;
            width: 100%;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="submit"] {
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
            border: none;
        }
    </style>
</head>

<body>
<header>
    <?php include 'navbar.php'; ?>
</header>

<div class="edit">
    <form action="" method="post">
        <input type="hidden" name="update" value="1">

        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password"  required>

        <label for="username">New Username:</label>
        <input type="text" id="username" name="username" pattern="[a-zA-Z]+" required>

        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" minlength="8" required>

        <label for="email">New Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="address">New Address:</label>
        <input type="text" id="address" name="address" required>

        <input type="submit" value="Confirm Changes">
    </form>
</div>

</body>
</html>
