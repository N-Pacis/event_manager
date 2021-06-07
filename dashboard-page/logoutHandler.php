 <?php
        session_start();
        $user = $_SESSION["username"];
        require_once '../utils/connection.php';
        if(!$connect){
                $_SESSION["error-message"] = "Connection Error!";
                header("Location: ../login-page/login.php");
        }
        else{
                session_unset();
                session_destroy();
                header("Location:../login-page/login.php");
        }
  ?>

