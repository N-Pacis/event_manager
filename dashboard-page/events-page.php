<?php
session_start();
require_once '../utils/connection.php';
if (!$connect) {
    $_SESSION["error-message"] = "Connection to the database failed";
    header("Location: ../login-page/login.php");
} else {
    $user = $_SESSION["username"];
    if (!$user) {
        $_SESSION["error-message"] = "You need to login first!";
        header("Location: ../login-page/login.php");
    } else {
        $selectUserQuery = mysqli_query($connect, "SELECT * FROM users where username='$user'");
        if (mysqli_num_rows($selectUserQuery) == 0) {
            $_SESSION["error-message"] = "No user found with the supplied username and password";
            header("Location: ../login-page/login.php");
        } else {
            $row = mysqli_fetch_assoc($selectUserQuery);
            $user_id = $row["user_id"];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="dashboard-page.css?v=<?php echo time(); ?>">
</head>

<body id="body" onload="clearSession()">
    <div class="navbar-div">
        <h1 class="app-title">EVENT MANAGER</h1>
        <div class="navbar-main-content">
            <nav>
                <ul>
                    <li><a href="" class="active">Events</a></li>
                    <li><a href="notifications-page.php">Notifications</a></li>
                </ul>
            </nav>
            <h2 class="profile-name"><?php echo $_SESSION["username"] ?></h2>
        </div>
    </div>
    <?php if ($_SESSION['error-message'] != "") : ?>
        <div class="error-message-div">
            <p><?php echo $_SESSION['error-message']; ?></p>
        </div>
    <?php endif; ?>
    <button class="new-event-btn" id="new-event-btn"><i class="fas fa-calendar-plus"></i>New Event</button>
    <?php
    $selectQuery = mysqli_query($connect, "SELECT * FROM events INNER JOIN users ON user_id=creator where creator=$user_id");
    if (mysqli_num_rows($selectQuery) == 0) {
    ?>
        <div class="no-events-div">
            <img src="../utils/images/events.svg" alt="no events">
            <h2 class="no-events-text">You have no events so far!</h2>
        </div>
    <?php
    } else {
    ?>

        <div class="events-div">
            <?php while ($row = mysqli_fetch_assoc($selectQuery)) {
                if ($row["username"] == $user) {
                    $creator = "you";
                } else {
                    $creator = $row["username"];
                }
            ?>
                <div class="event">
                    <a href="event.php?event=<?php echo $row['event_id'] ?>" class="events-link">
                        <div class="event-image">

                        </div>
                        <div class="event-description">
                            <h2 class="event-name"><?php echo $row["event_name"] ?></h2>
                            <p class="event-desc"><?php echo $row["event_description"] ?></p>
                            <p class="event-duration"><span>Date:</span><?php echo $row["event_duration"] ?></p>
                            <p class="event-creator">Created by <?php echo $creator ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    <?php
    }
    ?>
    <div class="event-form" id="event-form">
        <form action="add-eventHandler.php" method="post">
            <h1 class="new-event-title">Add A New Event </h1>
            <div class="form-group">
                <label for="event-name">Event Name</label>
                <input type="text" name="event-name" id="event-name" required>
            </div>
            <div class="form-group">
                <label for="event-desc">Event Description</label>
                <input type="text" name="event-desc" id="event-desc" required>
            </div>
            <div class="form-group">
                <label for="event-duration">Event Duration</label>
                <input type="date" name="event-duration" id="event-duration" min="<?php echo date("Y-m-d"); ?>" required>
            </div>
            <input type="submit" value="Add A New Event">
        </form>
    </div>
    <script type="text/javascript">
        document.getElementById('new-event-btn').addEventListener('click', function() {
            document.getElementById("event-form").style.display = "block";
            document.getElementById("body").style.overflowY = "hidden";
            document.querySelector(".error-message-div").style.display = "none";
        });

        function clearSession() {
            <?php
            $_SESSION['error-message'] = "";
            ?>
        }
    </script>
</body>

</html>