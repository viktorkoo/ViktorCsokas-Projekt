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

        .welcome-box {
            text-align: center;
            padding: 100px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #fff;
            font-size: 3vw
        }

    </style>
</head>
<body>
    <div class="welcome-box">
        <?php
            session_start();

            if(isset($_SESSION['username'])) {
                echo 'Čus '.$_SESSION['username'].'<br>';
                echo 'Click here to <a href="logout.php" title="Logout">logout.</a>';
            } else {
                echo 'Session not set.';
            }
        ?>
    </div>
</body>
</html>