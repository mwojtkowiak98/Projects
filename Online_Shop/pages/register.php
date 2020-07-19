<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Yerba Shop | Zarejestruj</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <div class="login-page">
    <div class="login-page-logo">
      <a href="./index.php"><img src="../yerba_logo.png" class="logo"></a>
    </div>

    <?php
      //Display errors from add_user.php
      if(isset($_SESSION['error'])){
      echo<<<ERROR
        <div class="error">
            <h3 class="error-title">{$_SESSION['error']}</h3>
        <div>
      ERROR;
        unset($_SESSION['error']);
      }
    ?>

    <div class="login-form">
        <p class="login-form-msg">Zarejestruj się</p>

        <!-- Register form  -->
        <form action="./scripts/add_user.php" method="post">
            <div class="input-group">
              <input type="text" placeholder="Imie" name="name">
            </div>
            <div class="input-group">
              <input type="text" placeholder="Nazwisko" name="surname">
            </div>
            <div class="input-group">
              <input type="email" placeholder="Email" name="email1">
            </div>
            <div class="input-group">
              <input type="email" placeholder="Powtórz Email" name="email2">
            </div>
            <div class="input-group">
              <input type="password" placeholder="Hasło" name="pass1">
            </div>
            <div class="input-group">
              <input type="password" placeholder="Powtórz hasło" name="pass2">
            </div>
          
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">Akceptuję warunki <a href="./index.php">regulaminu</a></label>

          <div class="input-group">
            <button type="submit" class="button">Zarejestruj</button>
          </div>
        </form>

        <div class="login-form-links">
          <a href="./login_page.php">Mam już konto</a>
        </div>

    </div>
  </div>
</body>
</html>