<?php
// Connection
include('config/db_connect.php');
require 'vendor/autoload.php'; // Ensure OTPHP library is loaded
use OTPHP\TOTP;

// Essential Variables
$errors = ["username" => "", "password" => "", "totp" => ""];
$username = $password = "";

if (isset($_POST['login'])) {
    if (!empty($_POST['username'])) {
        $username = htmlspecialchars($_POST['username']);
    }

    if (!empty($_POST['password'])) {
        $password = htmlspecialchars($_POST['password']);
    }

    if ($username && $password) {
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $storedSalt = $row['salt'];
            $storedHash = $row['password'];
            $storedSecret = $row['secret'];

            $inputPasswordWithSalt = $storedSalt . $password;

            if (password_verify($inputPasswordWithSalt, $storedHash)) {
                // Validate the TOTP code
                if (!empty($_POST['totp'])) {
                    $totp = TOTP::create($storedSecret);

                    if ($totp->verify($_POST['totp'])) {
                        // 2FA passed
                        session_start();
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['email'] = $row['email'];
                        session_regenerate_id(true);
                        header('Location: index_menu.php');
                        exit();
                    } else {
                        $errors['totp'] = "Invalid authentication code!";
                    }
                } else {
                    $errors['totp'] = "Authentication code is required!";
                }
            } else {
                $errors['password'] = "Password is incorrect!";
            }
        } else {
            $errors['username'] = "Username doesn't exist!";
        }
    }
}

// Additional cleanup if needed
mysqli_close($conn);
?>
