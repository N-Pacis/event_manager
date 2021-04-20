<?php
session_start();
require_once '../utils/connection.php';

if(!$connect){
    $_SESSION["error-message"] = "Connection to the database failed";
    header("Location: event.php?event=".$_SESSION['event_id']);
}
else{
    $user = mysqli_real_escape_string($connect,trim($_POST['search-user']));
    $event = $_SESSION["event_id"];


    if($user === "" || $event === "" || !$user || !$event ) {
        $_SESSION["error-message"] = "All fields are required";
        header("Location: event.php?event=".$_SESSION['event_id']);
    }
    else{
        $checkEventQuery=mysqli_query($connect,"SELECT * FROM events where event_id='$event'");
        if(mysqli_num_rows($checkEventQuery)==0){
            $_SESSION["error-message"] = "Unable to find the event";
            header("Location: event.php?event=".$_SESSION['event_id']);
        }
        else{
            $checkUserQuery = mysqli_query($connect,"SELECT * FROM users where username='$user'");
            if(mysqli_num_rows($checkUserQuery)==0){
                $_SESSION["error-message"] = "Unable to find the user";
                header("Location: event.php?event=".$_SESSION['event_id']);
            }
            else{
                $rowUser = mysqli_fetch_assoc($checkUserQuery);
                $user_id=$rowUser["user_id"];
                $insertQuery = mysqli_query($connect,"INSERT INTO event_members(event_id,user_id) values('$event','$user_id')");
                if(!$insertQuery){
                    $_SESSION["error-message"] = "Failed to add a new user due to ".mysqli_error($connect);
                    header("Location: event.php?event=".$_SESSION['event_id']);
                }
                else{
                    header("Location: event.php?event=".$_SESSION['event_id']);
                }
            }
        }
    }
}
?>