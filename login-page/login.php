<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginPage.css?v=<?php echo time() ?>">
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
        <form action="loginHandler.php" method="post">
            <h1 class="login-title">Login Here</h1>
            <div class="form-group">
                <label for="username">
                    Username:
                </label>
                <input type="text" name="username" id="username" placeholder="Enter your username..." autocomplete=false>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter your password..." autocomplete=false>
            </div>
            <input type="submit" value="Login">
            <p>Don't have an account?<a href="registrationPage.php">Register Here</a></p>
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