<?php
  session_start();
  //checking logged account
  if(isset($_SESSION['logged']['email'])){
    header('location: ../scripts/login.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Yerba Shop | Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <header class="menu">
  <a href="./index.php"><img src="../yerba_logo.png" class="logo"></a>
    <ul class="header-links">
      <li>
        <form action="./cart.php" method="post">
          <input type='submit' class="cart" name='product' value='Cart'>
          <a href="./cart.php"><img src="../cart_icon.png" class="cart-icon"></a>
         <!-- Zrobic sume koszyka -->
        </form>
      </li>

      <li><a href="./login_page.php"><button class = "login">Zaloguj</button></a></li>
    </ul>
  </header>
  <div class="space"></div>

  <div class="search-box">

  <img src="../search_icon.png" id="search-icon">

  <label for="gsearch"></label>
  <input type="search" id="gsearch" name="gsearch">

  </div>
  <div class="space"></div>

  <aside>
    <nav>
      <ul class="ul-categories"><h1>Kategorie</h1>
        <li><a href="#">
          <ul class="ul-categories2"><h2>Herbata</h2></a>
            <li><a href="#"><h3>mate green</h3></li></a>
            <li><a href="#"><h3>paraguayan</h3></li></a>
          </ul>
        </li>
        <li><a href="#"><h2>Zestawy</h2></li></a>
        <li><a href="#">
          <ul class="ul-categories2"><h2>Akcesoria</h2></a>
            <li><a href="#"><h3>bombille</h3></li></a>
            <li><a href="#"><h3>naczynia</h3></li></a>
          </ul>
        </li>
      </ul>
    </nav>
  </aside>

  <?php
    //connecting with database
    require_once '../scripts/connect.php';
    if($conn->connect_errno){
      $_SESSION['error'] = 'Błąd łączenia z bazą danych!';
      exit();
    }

      //returns products
      $sql = "SELECT  id, name, price, image FROM `products`";
      $result = $conn->query($sql);

      echo '<div class=content style="margin-left:18vw;margin-right:18vw;">';
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo '<div class=items style="display:flex; float:left;">';
          echo '<div class=item style="margin:30px;display:inline-block;">';
          echo  $row["name"]. " " . $row["price"]. "<br>";
          echo '<img id="img" style= "width: 200px; height:200px;" src="data:image/jpeg/png;base64,'.base64_encode( $row["image"] ).'"/> <br>';
          echo '</div>';
          echo '</div>';
        }
      }
      echo '</div>';
      $conn->close();
  ?>

</body>
</html>
