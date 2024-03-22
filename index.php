<?php
   session_start();   //otvorenie session
   
  $error = "";  

    //kontrola ci uz bol potvrdeny formular a ci boli vyplnene obidva udaje aj username aj password
   if (isset($_POST['login']) && !empty($_POST['username']) 
      && !empty($_POST['password'])) {

        //connect string do DB
        $servername = "localhost";
        $username = "csokas3a";
        $password = "csokas3a";
        $dbname = "csokas3a";

        // Create connection
        $conn = new mysqli($servername, $username, 
            $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        
        //echo "Connected successfully";

        //vyber hesla z DB podla usera, ktory sa prihlasuje
        $sql = "SELECT password FROM t_user where username ='".$_POST['username']."'";
        $result = $conn->query($sql);

        //ak vrati select viac ako 0 riadkov, user existuje
        if ($result->num_rows > 0) {
          // output data of each row
          $row = $result->fetch_assoc();
          //if($row["password"]==$_POST['password']) {
            if(password_verify($_POST['password'],$row["password"])) {
                $_SESSION['valid'] = true; //ulozenie session
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = $_POST['username'];

                //presmerovanie na dalsiu stranku
                header("Location: welcome.php", true, 301);
                exit();
          } else {
            $error = "wrong password";
          }
        } else {
          $error = "wrong username";
        }
    
    $conn->close();
   
}     
            
   //formular            
   echo '<html>';
   echo '<head>';
   echo '<title>Login form</title>';
   echo '<style>';
   echo 'body {';
   echo '    display: flex;';
   echo '    align-items: center;';
   echo '    justify-content: center;';
   echo '    height: 100vh;';
   echo '    margin: 0;';
   echo '    background-color: #f2f2f2;';
   echo '}';
   echo 'form {';
   echo '    background-color: #fff;';
   echo '    padding: 20px;';
   echo '    border-radius: 8px;';
   echo '    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);';
   echo '}';
   echo 'input {';
   echo '    width: 100%;';
   echo '    padding: 10px;';
   echo '    margin-bottom: 10px;';
   echo '    border: 1px solid #ccc;';
   echo '    border-radius: 4px;';
   echo '}';
   echo 'input[type="submit"] {';
   echo '    background-color: blue;';
   echo '    color: white;';
   echo '    cursor: pointer;';
   echo '}';
   echo 'p{';
   echo 'color: red;';
   echo 'text-align: center;';
   echo '}';
   echo 'a{';
   echo 'text-align: center;';
   echo '}';
   echo '</style>';
   echo '</head>';
   echo '<body>';
   echo '<form action="index.php" method="post">';
   echo '<input type="text" name="username" placeholder="username" required autofocus></br>';
   echo '<input type="password" name="password" placeholder="password" required>';
   echo '<input type="submit" name="login">';
   echo '<p>'.$error.'</p>';
   echo '<a href="register.php">Register</a>';
   echo '</form>';
   echo '</body>';
   echo '</html>';
  

?>