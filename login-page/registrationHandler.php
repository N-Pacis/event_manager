<?php
    session_start();
    require_once '../utils/connection.php';

    if(!$connect){
        $_SESSION["error-message"] = "Connection to the database failed";
        header("Location: registrationPage.php");
    }
    else{
        $username = mysqli_real_escape_string($connect,$_POST['username']);
        $firstname = mysqli_real_escape_string($connect,$_POST['firstname']);
        $lastname = mysqli_real_escape_string($connect,$_POST['firstname']);
        $email = mysqli_real_escape_string($connect,$_POST['email']);
        $password = mysqli_real_escape_string($connect,$_POST['password']);
        $repeat_password = mysqli_real_escape_string($connect,$_POST['repeat-password']);

    
        if($username === "" || $password === "" || $lastname === "" || $firstname === "" || $repeat_password === "" || $email === "" || !$username || !$password || !$lastname || !$firstname || !$repeat_password || !$email ) {
            $_SESSION["error-message"] = "All fields are required";
            header("Location: registrationPage.php");
        }
        else{
            if($password != $repeat_password){
                $_SESSION["error-message"] = "Both passwords do not match";
                header("Location: registrationPage.php");
            }
            else{
                $checkUsernameQuery=mysqli_query($connect,"SELECT * FROM users where username like '$username'");
                if(mysqli_num_rows($checkUsernameQuery)!=0){
                    $_SESSION["error-message"] = "User with the supplied username already exists";
                    header("Location: registrationPage.php");
                }
                else{
                    $checkEmailQuery = mysqli_query($connect,"SELECT * FROM users where email like '$email'");
                    if(mysqli_num_rows($checkEmailQuery)!=0){
                        $_SESSION["error-message"] = "User with the supplied email already exists";
                        header("Location: registrationPage.php");
                    }
                    else{
                        $hashed_password = hash('SHA512',$password);
                        $insertQuery = mysqli_query($connect,"INSERT INTO users(firstname,lastname,username,email,password) values('$firstname','$lastname','$username','$email','$hashed_password')");
                        if(!$insertQuery){
                            $_SESSION["error-message"] = "Failed to register user due to ".mysqli_error($connect);
                            header("Location: registrationPage.php");
                        }
                        else{
                            $_SESSION["username"] = $username;
                            header("Location: ../dashboard-page/events-page.php");
                        }
                    }
                }
            }
        }
    }
    
?>