<?php
session_start();
require_once '../utils/connection.php';
if (!$connect) {
    $_SESSION["error-message"] = "Connection to the database failed";
    header("Location: ../login-page/loginPage.php");
} else {
    $user = $_SESSION["username"];
    if (!$user) {
        $_SESSION["error-message"] = "You need to login first!";
        header("Location: ../login-page/loginPage.php");
    } else {
        $selectUserQuery = mysqli_query($connect, "SELECT * FROM users where username='$user'");
        if (mysqli_num_rows($selectUserQuery) == 0) {
            $_SESSION["error-message"] = "No user found with the supplied username and password";
            header("Location: ../login-page/loginPage.php");
        } else {
            $event = $_GET['event'];
            if(!$event){
               header("Location: events-page.php");
            }
            else{
                $selectEventQuery = mysqli_query($connect,"SELECT * FROM events where event_id=$event");
                if(!$selectEventQuery){
                    $_SESSION["error-message"] = "Invalid event!";
                    header("Location: events-page.php");
                }
                else{
                    $row=mysqli_fetch_assoc($selectEventQuery);
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row["event_name"]?></title>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="dashboard-page.css?v=<?php echo time(); ?>">
</head>

<body id="body" onload="clearSession()">
    <a href="events-page.php" class="go-back-link">
    <i class="fas fa-angle-double-left"></i>Go back
    </a>
    <div class="event-page-image">
        <i class="fas fa-photo-video"></i>
        <p class="event-page-image-text">Event Image Here</p>
    </div>
    <div class="event-page-title">
        <h2 class="event-page-title-text"><?php echo $row["event_name"]?></h2>
    </div>
    <div class="event-page-description">
        <p class="event-page-description-paragraph"><?php echo $row["event_description"]?></p>
        <p class="event-page-duration"><span>Date:</span><?php echo $row["event_duration"]?></p>
        <div class="event-members">
            <div class="search-member">
                <i class="fas fa-search"></i>
                <input type="text" name="search-member" id="search-member" placeholder="Find A participant...">
            </div>
            <div class="members">
                <p>The event has no participants yet</p>
                <button id="invite-participant-btn">Invite a participant</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function clearSession() {
            <?php
            $_SESSION['error-message'] = "";
            ?>
        }
    </script>
</body>

</html>