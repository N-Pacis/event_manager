<?php
    session_start();
    require_once '../utils/connection.php';

    if(!$connect){
        $_SESSION["error-message"] = "Connection to the database failed";
        header("Location: events-page.php");
    }
    else{
        $event_name = mysqli_real_escape_string($connect,trim($_POST['event-name']));
        $event_desc = mysqli_real_escape_string($connect,trim($_POST['event-desc']));
        $event_dur = mysqli_real_escape_string($connect,trim($_POST['event-duration']));
        $creator = $_SESSION["username"];

    
        if($event_name === "" || $event_desc === "" || $event_dur === "" || $creator === "" || !$event_name || !$event_desc || !$event_dur || !$creator ) {
            $_SESSION["error-message"] = "All fields are required";
            header("Location: events-page.php");
        }
        else{
                $checkCreatorQuery=mysqli_query($connect,"SELECT * FROM users where username like '$creator'");
                if(mysqli_num_rows($checkCreatorQuery)==0){
                    $_SESSION["error-message"] = "Unable to find the creator for the event";
                    header("Location: events-page.php");
                }
                else{
                        $row=mysqli_fetch_assoc($checkCreatorQuery);
                        $user_id = $row["user_id"];
                        $insertQuery = mysqli_query($connect,"INSERT INTO events(event_name,event_description,event_duration,creator) values('$event_name','$event_desc','$event_dur','$user_id')");
                        if(!$insertQuery){
                            $_SESSION["error-message"] = "Failed to add a new event due to ".mysqli_error($connect);
                            header("Location: events-page.php");
                        }
                        else{
                            header("Location: ../dashboard-page/events-page.php");
                        }
                    }
                }
            }
?>