<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Yerba Shop | Zaloguj</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <div class="login-page">

    <div class="login-page-logo">
      <a href="./index.php"><img src="../yerba_logo.png" class="logo"></a>
    </div>

    <?php
      //display errors from script login.php
      if(isset($_SESSION['error'])){
        //heredoc
      echo<<<ERROR
        <div class="error">
            <h3 class="error-title">{$_SESSION['error']}</h3>
        </div>
      ERROR;
      unset($_SESSION['error']);
      }
    ?>

      <div class="login-form">
          <p class="login-form-msg">Zaloguj się</p>

        <!-- Login form -->
        <form action="../scripts/login.php" method="post">
          <div class="input-group">
            <input type="email" placeholder="Email" name="email">
          </div>
          <div class="input-group">
            <input type="password" placeholder="Hasło" name="pass">
          </div>

          <div class="input-group">
            <button type="submit" class="button">Zaloguj</button>
          </div>

        </form>

        <p class="login-form-links">
          <a href="./forgot_password.php">Zapomniałem hasła</a>
        </p>
        <p class="login-form-links">
          <a href="./register.php">Stwórz nowe konto</a>
        </p>
      </div>

  </div>
</body>
</html>
