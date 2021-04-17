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
        <form action="registrationHandler.php" method="post">
            <h1 class="login-title">Register Here</h1>
            <div class="form-group">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstname" id="firstname" placeholder="Enter your firstname...">
            </div>
            <div class="form-group">
                <label for="lastname">Lastname:</label>
                <input type="text" name="lastname" id="lastname" placeholder="Enter your lastname...">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" placeholder="Enter your email...">
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Enter your username...">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter your password...">
            </div>
            <div class="form-group">
                <label for="repeat-password">Repeat Password:</label>
                <input type="password" name="repeat-password" id="repeat-password" placeholder="Repeat your entered password...">
            </div>
            <input type="submit" value="Register">
            <p>Already have an account?<a href="login.php">Login Here</a></p>
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