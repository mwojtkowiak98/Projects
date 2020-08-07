<?php
  session_start();
  //checking logged account, prem = 1 is user, prem = 2 is admin
  if($_SESSION['logged']['permission'] != 1 ){
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
  <link rel="stylesheet" href="../pages/style.css">
</head>
<body>
  <header class="menu">
  <a href="../pages/index.php"><img src="../yerba_logo.png" class="logo"></a>
    <ul class="header-links">

      <!-- User display -->
      <li><div class = "login">Witaj : <?php echo $_SESSION['logged']['name']; ?></div></li>

      <li>
        <form action="../pages/cart.php" method="post">
          <a href="../pages/cart.php"><img src="../cart_icon.png" class="cart-icon"></a>
         <!-- Zrobic sume koszyka -->
        </form>
      </li>

      <!-- Logout button -->
      <li><a href="../scripts/logout.php"><button class = "login">Wyloguj</button></a></li>
    </ul>
  </header>
  <div class="space"></div>

  <div class="cointainer-parallax">
    <div class="parallax"><p>Yerba mate z całego świata.</p></div>
  </div>

  <!-- Search input -->
  <div class="search-box">
  <img src="../search_icon.png" id="search-icon">

  <form action=./user.php method=get>
    <input type="search" id="gsearch" name="query" placeholder="Szukaj produktu...">
  </form>
  </div>

  <div class="space"></div>

  <aside>
    <nav>
      <ul class="ul-categories"><h1>Kategorie</h1>
        <li><form action=./user.php?-Herbata method=post>
          <ul class="ul-categories2"><button type = submit class=cat-button name = herbata value = herbata><h2>Herbata</h2></button></form>
            <li><form action=./user.php?-mate-green method=post>
            <button type = submit class=cat-button name = herbata value = mate-green><h3>mate green</h3></button></form>
            </li>
            <li><form action=./user.php?-paraguayan method=post>
            <button type = submit class=cat-button name = herbata value = paraguayan><h3>paraguayan</h3></button></form>
            </li>
          </ul>
        </li>
        <li><form action=./user.php?-zestawy method=post>
        <button type = submit class=cat-button name = zestawy value = zestawy><h2>Zestawy</h2></button></form>
        </li>
        <li><form action=./user.php?-Akcesoria method=post>
          <ul class="ul-categories2"><button type = submit class=cat-button name = akcesoria value = akcesoria><h2>Akcesoria</h2></button></form>
            <li><form action=./user.php?-bombille method=post>
            <button type = submit class=cat-button name = akcesoria value = bombille><h3>bombille</h3></button></form>
            </li>
            <li><form action=./user.php?-naczynia method=post>
            <button type = submit class=cat-button name = akcesoria value = naczynia><h3>naczynia</h3></button></form>
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

      //returns products from search input
      else if(strpos($_SERVER['REQUEST_URI'], "?query=")){
        $query = $_GET['query'];
        $sql = "SELECT id, name, price, image FROM `products` WHERE (`name` LIKE '%".$query."%')";
      }


      $result = $conn->query($sql);
      echo '<div class=page-wrapper>';

      //styles are used here just to test something. It should be in css file.(it makes a lot of mess here)
      echo '<div class=content style="margin-left:21vw;margin-right:18vw;">';

      //post item to cart
      echo  '<form action="" method="post">';

      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo '<div class=items style="display:flex; float:left;">';
          echo '<div class=item style="margin:30px;display:inline-block; text-align:center; background-color: lightyellow; cursor:pointer;
          box-shadow: 0px 2px limegreen">';
          echo  $row["name"]."<br>";
          echo '<img id="img" style= "width: 200px; height:200px;" src="data:image/jpeg/png;base64,'.base64_encode( $row["image"] ).'"/> <br>';
          echo  $row["price"]. " zł"."<br>";
          echo "<button type='submit' style='background-color:#e4ffe5; cursor:pointer; padding:3px;' name='product' value='$row[name]'> Do koszyka </button>";
          echo '</div>';
          echo '</div>';
        }
      }
      echo "</form>";   
      echo '</div>';

      //Footer isn't fully responsive. Works properly only for list of all products, because page doesn't refresh when we choose category.
      //In result we get a lot of empty space between products and footer (when we choose a category with less results)
      echo<<<FOOTER
      <footer id="main-footer">
      <div id="footer-info">
        <ul><h4>Informacje</h4>
          <li>O nas</li>
        </ul>
        <ul><h4>Kontakt</h4>
          <li>000-000-000</li>
          <li>example@example.com</li>
          <li>ul. Przykładowa 1, 00-000 Przykład</li>
        </ul>
      </div>
      <div id="copyright"><p>Copyright &copy; YerbaShop 2020</p></div>
      </footer>
      FOOTER;

      //save product in session variable
      if(isset($_POST['product'])){
        $product = $_POST['product'];
        if(!isset($_SESSION['product'][$product])) $_SESSION['product'][$product] = 1;
        else $_SESSION['product'][$product]++;
      }

      $conn->close();

      //end of page-wrapper
      echo '</div>';
  ?>

</body>
</html>