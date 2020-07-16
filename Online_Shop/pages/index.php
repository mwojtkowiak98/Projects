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
        <li><form action=./index.php?-Herbata method=post>
          <ul class="ul-categories2"><button type = submit name = herbata value = herbata><h2>Herbata</h2></button></form>
            <li><form action=./index.php?-mate-green method=post>
            <button type = submit name = herbata value = mate-green><h3>mate green</h3></button></form>
            </li>
            <li><form action=./index.php?-paraguayan method=post>
            <button type = submit name = herbata value = paraguayan><h3>paraguayan</h3></button></form>
            </li>
          </ul>
        </li>
        <li><form action=./index.php?-zestawy method=post>
        <button type = submit name = zestawy value = zestawy><h2>Zestawy</h2></button></form>
        </li>
        <li><form action=./index.php?-Akcesoria method=post>
          <ul class="ul-categories2"><button type = submit name = akcesoria value = akcesoria><h2>Akcesoria</h2></button></form>
            <li><form action=./index.php?-bombille method=post>
            <button type = submit name = akcesoria value = bombille><h3>bombille</h3></button></form>
            </li>
            <li><form action=./index.php?-naczynia method=post>
            <button type = submit name = akcesoria value = naczynia><h3>naczynia</h3></button></form>
            </li>
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

      if(strpos($_SERVER['REQUEST_URI'], "?-Herbata")){
        $sql = "SELECT  id, name, price, image FROM `products` WHERE kategoria = 'herbata'";
      } else if(strpos($_SERVER['REQUEST_URI'], "?-mate-green")){
        $sql = "SELECT  id, name, price, image FROM `products` WHERE podkategoria = 'mate_green'";
      } else if(strpos($_SERVER['REQUEST_URI'], "?-paraguayan")){
        $sql = "SELECT  id, name, price, image FROM `products` WHERE podkategoria = 'paraguayan'";
      } else if(strpos($_SERVER['REQUEST_URI'], "?-zestawy")){
        $sql = "SELECT  id, name, price, image FROM `products` WHERE kategoria = 'zestawy'";
      } else if(strpos($_SERVER['REQUEST_URI'], "?-Akcesoria")){
        $sql = "SELECT  id, name, price, image FROM `products` WHERE kategoria = 'akcesoria'";
      } else if(strpos($_SERVER['REQUEST_URI'], "?-bombille")){
        $sql = "SELECT  id, name, price, image FROM `products` WHERE podkategoria = 'bombille'";
      } else if(strpos($_SERVER['REQUEST_URI'], "?-naczynia")){
        $sql = "SELECT  id, name, price, image FROM `products` WHERE podkategoria = 'naczynia'";
      }



      $result = $conn->query($sql);

      echo '<div class=content style="margin-left:18vw;margin-right:18vw;">';

      //post item to cart
      echo  '<form action="" method="post">';

      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo '<div class=items style="display:flex; float:left;">';
          echo '<div class=item style="margin:30px;display:inline-block; text-align:center; background-color: lightyellow">';
          echo  $row["name"]."<br>";
          echo '<img id="img" style= "width: 200px; height:200px;" src="data:image/jpeg/png;base64,'.base64_encode( $row["image"] ).'"/> <br>';
          echo  $row["price"]. " zł"."<br>";
          echo "<button type='submit' style=background-color:#e4ffe5; name='product' value='$row[name]'> Do koszyka </button>";
          echo '</div>';
          echo '</div>';
        }
      }
      echo '</div>';

      //save product in session variable
      echo "</form>";
      if(isset($_POST['product'])){
        $product = $_POST['product'];
        if(!isset($_SESSION['product'][$product])) $_SESSION['product'][$product] = 1;
        else $_SESSION['product'][$product]++;
      }

      $conn->close();
  ?>

</body>
</html>
