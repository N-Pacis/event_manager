<?php
    session_start();
    require_once '../utils/connection.php';

    if(!$connect){
        $_SESSION["error-message"] = "Connection to the database failed";
        header("Location: loginPage.php");
    }
    else{
        $username = mysqli_real_escape_string($connect,$_POST['username']);
        $password = mysqli_real_escape_string($connect,$_POST['password']);
    
        if($username === "" || $password === "" || !$username || !$password) {
            $_SESSION["error-message"] = "All fields are required";
            header("Location: loginPage.php");
        }
        else{
           $hashed_password = hash('SHA512',$password);
           $checkUserQuery = mysqli_query($connect,"SELECT * FROM users WHERE username like '$username' AND password='$hashed_password'");
           if(mysqli_num_rows($checkUserQuery) == 0){
                $_SESSION["error-message"] = "Incorrect username or password";
                header("Location: loginPage.php");  
           }
           else{
                $_SESSION["username"] = $username;
                header("Location: ../dashboard-page/events-page.php");
           }
        }
    }
    
?>