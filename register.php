<?php
$error = " ";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "csokas3a";
    $password = "csokas3a";
    $dbname = "csokas3a";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $input_username = $_POST['username'];
    $input_password = $_POST['password'];
    $input_confirm_password = $_POST['confirm_password'];
    $input_email = $_POST['email'];

    $check_username_sql = "SELECT * FROM t_user WHERE username='$input_username'";
    $result = $conn->query($check_username_sql);
    $check_email_sql = "SELECT * FROM t_user WHERE email='$input_email'";
    $result2 = $conn->query($check_email_sql);

    if ($result->num_rows > 0) {
        $error = "Username already exists. Please choose a different username.";
    } else {
        if ($result2->num_rows > 0) {
            $error = "E-mail already in use";
        } else {
            if ($input_password !== $input_confirm_password) {
                $error = "Passwords do not match";
            } else {
                $input_password = password_hash($input_password, PASSWORD_DEFAULT);
                $insert_sql = "INSERT INTO t_user (username, password, email) VALUES ('$input_username', '$input_password', '$input_email')";

                if ($conn->query($insert_sql) === TRUE) {
                    $error = "New login created";
                } else {
                    $error = "User already exists";
                }
            }
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      background: linear-gradient(to right, #9D9E9E, #C8CCCC);
      font-family: Arial, sans-serif;
    }
    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      max-width: 400px;
      width: 100%;
      text-align: center;
    }
    .container h2 {
      margin-bottom: 20px;
      color: #333;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 15px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      background-color: #6D7070;
      color: white;
      padding: 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    input[type="submit"]:hover {
      background-color: #2F3030;
    }
    .message {
      color: red;
      margin: 10px 0;
    }
    .link {
      margin-top: 20px;
      display: block;
      color: #6D7070;
      text-decoration: none;
    }
    .link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Create Account</h2>
  <form action="register.php" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <input type="submit" value="Register">
    <p class="message"><?php echo $error; ?></p>
    <a class="link" href="login.php">Already have an account? Login here</a>
  </form>
</div>

</body>
</html>
