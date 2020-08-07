<?php
session_start();
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
  <div class="login-page">

    <div class="login-page-logo">
      <a href="./index.php"><img src="../yerba_logo.png" class="logo"></a>
    </div>

    <?php
        //Display user name
        if(isset($_SESSION['logged']['email'])){
          echo "<div class = 'login'> Witaj: ".$_SESSION['logged']['name']."</div>";
        } else echo "<div class = 'error'>Zaloguj się aby dokończyć zakupy</div>";
    ?>

        <div class="space"></div>

    <div class="login-form">
      <?php
        if(isset($_SESSION['logged']['email'])){
          echo '<a href="../scripts/logout.php" class="login">Wyloguj</a>';
        }
        else echo '<a href="./login_page.php" class="button button-cart">Zaloguj</a>';
      ?>
      <?php
      require_once '../scripts/connect.php';
        if($conn->connect_errno){
          $_SESSION['error'] = 'Błąd łączenia z bazą danych!';
          exit();
        }

        //Deleting products from cart
        function serve_post(){
            if(isset($_POST['product-'])){
                $product = $_POST['product-'];
                if($_SESSION['product'][$product]==1) unset($_SESSION['product'][$product]);
                else $_SESSION['product'][$product]--;
                header("Refresh:0");
            }
          }
        
        //Display products added to cart
        function generate_cart(){
            echo "   
            <form action = '' class = 'generatedCart' method = 'post'>
            <table class='generatedCart' border='0px solid'>
            <br><caption><br>Koszyk</caption>
            <th>Nr.</th><th>Produkt</th><th>Ilość</th><th>Cena</th><th>Usuń</th>
            ";
            $counter=0;
            global $total;
            $total=0;
            
            if(isset($_SESSION['product'])){
                foreach($_SESSION['product'] as $name=>$quantity){
                    $counter++;
                    
                    //new conn to get price associated with name
                    $conn2= new mysqli('localhost', 'root', '', 'yerba_shop');
                    $result = mysqli_query($conn2, "SELECT price FROM products WHERE name = '$name'");
                      while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                        <td>$counter</td><td>$name</td><td>$quantity</td><td>$row[price]zł</td>
                        <td><button type='submit' name='product-' value='$name' class='delete'>Usuń</button></td>
                        ";
                        
                        $total+=$quantity*$row['price'];
                      }
                    //clear result set
                    mysqli_free_result($result);
                }
                echo "</table><br><div id=total>Do zapłaty: $total"."zł</div>";
            } else echo "<div class = 'user'>Twój koszyk jest pusty</div>";

            //close conn2
            if(!empty($conn2)) mysqli_close($conn2);
        }

        generate_cart();
        serve_post();

        //close conn
        mysqli_close($conn);
      ?>

    <button type="submit" name="order" id="order" value="total">Zamawiam</button>
    </div>
</div>
</body>
</html>