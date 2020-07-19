<?php
    session_start();
    //check if account is logged, close session
    if(isset($_SESSION['logged']['email'])){
        session_destroy();
        header("location: ../pages/index.php");
        exit();
    }

    header('location: ../');
?>