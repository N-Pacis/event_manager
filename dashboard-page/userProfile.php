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
    <script src="https://kit.fontawesome.com/1681f60826.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dashboard-page.css?v=<?php echo time(); ?>">
</head>

<body id="body">
<div class="navbar-div">
        <h1 class="app-title">EVENT MANAGER</h1>
        <div class="navbar-main-content">
            <nav>
                <ul>
                    <li><a href="events-page.php" class="active">Events</a></li>
                    <li><a href="notifications-page.php">Notifications</a></li>
                </ul>
            </nav>
        </div>
    </div>
<div class="user-info-primary">
    <img src="../profileUploads/<?php echo $row['profilePic']?>" alt="<?php echo $row['username']?>" class="profile-picture">
    <h1 class="full-name"><b>Full Name:</b> <?php echo $row['firstname'].' '.$row['lastname']?></h1>
    <p class="username"><b>Username:</b>    <?php echo $row['username']?></p>
    <p class="email"><b>Email:</b><?php echo $row['email']?></p>
</div>
<div class="user-action">
    <a class="update-profile-btn" href="updateProfileForm.php"><i class="fas fa-calendar-plus"></i>Update Profile</a>
    <a class="delete-profile-btn" href="deleteProfile.php"><i class="fas fa-calendar-plus"></i>Delete Account</a>
</div>
</body>

</html>