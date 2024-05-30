<html>
<a href="welcome.php"><span class="home">CarDealerz</span></a>
  <div class="dropdown" style="float:right;">
      <button class="dropbtn">Konto</button>
          <div class="dropdown-content">
            <a href="kosik.php">Kosik</a>
            <a href="logout.php">Odhlasenie</a>
<?php
    if(isset($_SESSION['username']) || $_SESSION['username'] == 'admin') {
     echo '<a href="manage.php">Admin</a>';
    }
?>
          </div>
  </div>
</html>