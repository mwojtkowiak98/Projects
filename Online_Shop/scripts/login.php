<?php
    session_start();

    //Check who is logged
    if(isset($_SESSION['logged']['email'])){
        if($_SESSION['logged']['permission'] == 1) header('location: ../logged/user.php');
        if($_SESSION['logged']['permission'] == 2) header('location: ../logged/admin.php');
    }
    else{
    
        //check if required fields are filled
        if(!empty($_POST['email']) && !empty($_POST['pass'])){

            //write informations to variables
            $email = $_POST['email'];
            $pass = $_POST['pass'];

            //Connect with database
            require_once './connect.php';
            
            //Check if email is already in database
            $sql = "SELECT * FROM `users` WHERE `email` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $error = 0;
            
            //email is correct
            if($result->num_rows == 1){
                $user = $result->fetch_assoc();

                //check if password matches email
                if(password_verify($pass, $user['password'])){
                    
                    //write inf about user to session variable
                    $_SESSION['logged']['name'] = $user['name'];
                    $_SESSION['logged']['surname'] = $user['surname'];
                    $_SESSION['logged']['email'] = $user['email'];
                    $_SESSION['logged']['permission'] = $user['permission_id'];
                    
                    //checking permissions
                    switch($user['permission_id']){
                        case 1:
                            header('location: ../logged/user.php');
                            break;
                        case 2:
                            header('location: ../logged/admin.php');
                            break;
                    }
                    exit();
                }

                //error display - wrong login or password
                else{
                    $error = 1;
                    $_SESSION['error'] = "Błędny login lub hasło";
                }
            }

            else{
                $error = 1;
                $_SESSION['error'] = "Błędny login lub hasło";
            }

            //error
            if($error == 1){
                ?>
                    <script>
                        history.back();
                    </script>
                <?php
            }
        }

        //back to previous page and inform user whats wrong
        else{
            $_SESSION['error'] = 'Wypełnij wszystkie pola';    
            ?>
                <script>
                    history.back();
                </script>
            <?php
        }
    }
?>