<?php
    session_start();
    //Check if all fields are filled
    if (!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email1']) && !empty($_POST['email2']) && !empty($_POST['pass1'])
    && !empty($_POST['pass2'])) {
        
        $error=0;

        if(!isset($_POST['terms'])){
            $error=1;
            $_SESSION['error'] = 'Zaznacz regulamin';
        }
        
        if($_POST['pass1'] != $_POST['pass2']){
            $error=1;
            $_SESSION['error'] = 'Hasła są różne';
        }
        
        if($_POST['email1'] != $_POST['email2']){
            $error=1;
            $_SESSION['error'] = 'Adresy email są różne';
        }
        
        //error = back to previous page and display one of above informations
        if($error != 0){
            ?>
                <script>
                    history.back();
                </script>
            <?php
            exit();
        }

        //save infos to session variable
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $pass1 = $_POST['pass1'];
        $email1 = $_POST['email1'];

        //Encrypting password with Argon2ID
        $pass = password_hash($pass1, PASSWORD_ARGON2ID);

        //Connect with database
        require_once './connect.php';
        if($conn->connect_errno){
            $_SESSION['error'] = 'Nie można połączyć się z bazą';
            header('location: ../pages/register.php');
            exit();
        }
        
        //put infos from form to database
        $sql = "INSERT INTO `users`(`name`, `surname`, `email`, `password`) VALUES(?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $name, $surname, $email1, $pass);

        //if succes --> login page
        if($stmt->execute()){
            $conn->close();
            $stmt->close();
            header('location: ../pages/login_page.php');
            $_SESSION['error'] = 'Rejestracja zakończona powodzeniem';
        }

        //check if email is in database
        else{
            $sql = "SELECT * FROM `users` WHERE `email` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email1);
            $stmt->execute();

            //if email already exist in database:
            if($conn->affected_rows){
                $_SESSION['error'] = 'Podany adres email jest już przypisany do konta';
            }
            else{
                $_SESSION['error'] = "Nie dodano użytkowanika do bazy danych";
            }
        }

        //Close db connection
        $conn->close();
        $stmt->close();

    }
    //back to previous page and display alert
    else{
        $_SESSION['error'] = 'Wypełnij wszystkie pola!';
        ?>
            <script>
                history.back();
            </script>
        <?php
    }
?>