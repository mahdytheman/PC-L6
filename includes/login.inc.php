<?php
// Connection
include('config/db_connect.php');

// Essential Variables
$errors = ["username" => "", "email" => ""];
$username = $email = $password = $hashedPass = $salt = "";
$username_valid = $email_valid = $password_valid = false;

if (isset($_POST['signup'])) {
    // Username Validation
    if (!empty($_POST['username'])) {
        $username = htmlspecialchars($_POST['username']);
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $errors['username'] = "Username already exists!";
        } else {
            $username_valid = true;
        }
    }

    // Email Validation
    if (!empty($_POST['email'])) {
        $email = htmlspecialchars($_POST['email']);
        $sql = "SELECT * FROM accounts WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = "Email already exists!";
        } else {
            $email_valid = true;
        }
    }

    // Password Handling
    if (!empty($_POST['password2'])) {
        $password = htmlspecialchars($_POST['password2']);
        // Generate a custom salt
        $salt = bin2hex(random_bytes(16)); // 16 bytes = 32-character salt
        // Append salt to the password and hash
        $saltedPassword = $salt . $password;
        $hashedPass = password_hash($saltedPassword, PASSWORD_DEFAULT);
        $password_valid = true;
    }

    // Insert into Database
    if ($password_valid && $email_valid && $username_valid) {
        $sql = "INSERT INTO accounts (username, email, password, salt) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPass, $salt);

        if (mysqli_stmt_execute($stmt)) {
            header("location: login.php");
            exit(); // Stop script execution after redirection
        } else {
            echo "ERROR: " . mysqli_error($conn);
        }
    }
}

// Additional cleanup if needed
mysqli_close($conn);
?>
