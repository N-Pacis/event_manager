<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <script src="https://use.fontawesome.com/4dc28ec4cb.js"></script>
    <link rel="stylesheet" href="dashboard-page.css?v=<?php echo time();?>">
</head>

<body>
    <div class="navbar-div">
        <h1 class="app-title">EVENT MANAGER</h1>
        <div class="navbar-main-content">
            <nav>
                <ul>
                    <li><a href="events-page.php">Events</a></li>
                    <li><a href="" class="active">Notifications</a></li>
                </ul>
            </nav>
            <h2 class="profile-name"><?php echo $_SESSION["username"] ?></h2>
        </div>
    </div>
            <div class="no-events-div">
                <img src="../utils/images/notifications.svg" alt="no notifications">
                <h2 class="no-events-text">You have no notifications so far!</h2>
            </div>
    ?>
</body>

</html>