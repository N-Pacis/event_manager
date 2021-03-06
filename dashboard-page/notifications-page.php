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
    <title>Notifications</title>
    <script src="https://kit.fontawesome.com/1681f60826.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dashboard-page.css?v=<?php echo time();?>">
</head>

<body>
    <div class="navbar-div">
        <h1 class="app-title">EVENT MANAGER</h1>
        <div class="navbar-main-content">
            <nav>
                <ul>
                    <li><a href="">Events</a></li>
                    <li><a href="notifications-page.php" class="active">Notifications</a></li>
                </ul>
            </nav>
            <div class="profile-info">
                <img src="../profileUploads/<?php echo $row['profilePic']; ?>" alt="<?php echo $row['profilePic'];?>" class="profilePic">
                <h2 class="profile-name"><?php echo $_SESSION["username"] ?></h2>
                <label for="check"><i class="fas fa-user-cog"></i></label>
                <input type="checkbox" id="check">
                <div class="user-option">
                    <a href="userProfile.php"><i class="fas fa-user"></i>Profile</a>
                    <a href="logoutHandler.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </div>
            </div>
        </div>
    </div>
            <div class="no-events-div">
                <img src="../utils/images/notifications.svg" alt="no notifications">
                <h2 class="no-events-text">You have no notifications so far!</h2>
            </div>
    ?>
</body>

</html>