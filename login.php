<?php
include("includes/login.inc.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<link rel="stylesheet" href="assets/styles_nav.css">
<link rel="stylesheet" href="assets/styles_login.css">
<body>
    <?php include('templates/nav.php') ?>
    <h1>Log In</h1>

    <form id="validate" action="login.php" method="POST">
        <input type="text" name="username" value="<?php echo $username ?>" placeholder="Enter your username..">
        <div class="danger"> <p><?php echo $errors['username'] ?></p> </div>
        <input type="hidden" name="username-valid" value="">

        <input type="password" name="password" value="" placeholder="Enter your password..">
        <div class="danger"> <p><?php echo $errors['password'] ?></p> </div>
        <input type="hidden" name="password-valid" value="">

        <input type="submit" name="login" value="Login">
    </form>

    <script type="text/javascript" src="js/formValidationLogin.js"></script>
</body>
</html>
