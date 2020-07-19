<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Yerba Shop | Reset</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="login-page">
    <a href="./index.php"><img src="../yerba_logo.png" class="logo"></a>

        <p class="login-box-msg">Podaj email</p>    
            <form action="javascript:history.back()" method="post">
                <div class="input-group">
                    <input required type="email" placeholder="Email" name="email">
                </div>

                    <!-- Communicat -->
                    <?php
                        $_SESSION['error'] = 'Link do zmiany hasła został wysłany na podany email';  
                    ?>

            <button type="submit" class="button">Reset</button>
            </form>
    </div>

</body>
</html>