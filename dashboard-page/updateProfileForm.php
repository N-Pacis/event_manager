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
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../login-page/loginPage.css?v=<?php echo time() ?>">
    <title>Event-manager</title>
</head>

<body onload="clearSession()">
    <main>
        <?php if ($_SESSION['error-message'] != "") : ?>
            <div class="error-message-div">
                <p><?php echo $_SESSION['error-message']; ?></p>
            </div>
        <?php endif; ?>
        <h1 class="app-title">Event Manager</h1>
        <form action="updateProfileHandler.php" method="post" enctype="multipart/form-data">
            <h1 class="login-title">Update Yout Info</h1>
            <div class="form-group">
                <input type="hidden" name="userId" id="userId" placeholder="Enter your firstname..." value="<?php echo $row['user_id']?>">
            </div>
            <div class="form-group">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstname" id="firstname" placeholder="Enter your firstname..." value="<?php echo $row['firstname']?>">
            </div>
            <div class="form-group">
                <label for="lastname">Lastname:</label>
                <input type="text" name="lastname" id="lastname" placeholder="Enter your lastname..." value="<?php echo $row['lastname']?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" placeholder="Enter your email..." value="<?php echo $row['email']?>">
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Enter your username..." value="<?php echo $row['username']?>">
            </div>
            <div class="form-group">
                <label for="profilePic">Profile Picture:</label>
                <img src="../profileUploads/<?php echo $row['profilePic']?>" alt="<?php echo $row['username']?>" class="profile-picture">
                <input type="file" name="profilePic" id="profilePic">
            </div>
            <input type="submit" value="Update">
        </form>
        <script>
            function clearSession() {
                <?php
                $_SESSION['error-message'] = "";
                ?>
            }
        </script>
    </main>
    <?php include '../utils/footer.php' ?>
</body>

</html>