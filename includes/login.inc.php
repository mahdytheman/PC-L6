<?php
// Connection
include('config/db_connect.php');
require 'vendor/autoload.php'; // Include Composer autoloader for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;

// Essential Variables
$errors = ["username" => "", "password" => "", "2fa" => ""];
$username = $password = "";
$sharedKey = "";

// Secure session setup
session_set_cookie_params([
    'lifetime' => 0,
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();

if (isset($_POST['login'])) {
    // Step 1: Validate Username and Password
    if (!empty($_POST['username'])) {
        $username = htmlspecialchars($_POST['username']);
    } else {
        $errors['username'] = "Username is required!";
    }

    if (!empty($_POST['password'])) {
        $password = htmlspecialchars($_POST['password']);
    } else {
        $errors['password'] = "Password is required!";
    }

    if ($username && $password) {
        // Check if user exists
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $storedSalt = $row['salt'];
            $storedHash = $row['password'];

            $inputPasswordWithSalt = $storedSalt . $password;

            if (password_verify($inputPasswordWithSalt, $storedHash)) {
                // Step 2: Generate Shared Key using Diffie-Hellman
                $clientPrivateKey = random_int(1000, 9999); // Simulate client key
                $serverPrivateKey = random_int(1000, 9999);
                $prime = 23;  // A small prime number for simplicity
                $base = 5;    // Base value

                // Public keys
                $clientPublicKey = pow($base, $clientPrivateKey) % $prime;
                $serverPublicKey = pow($base, $serverPrivateKey) % $prime;

                // Shared secret
                $sharedKey = pow($clientPublicKey, $serverPrivateKey) % $prime;

                // Store sharedKey and username in session, but don't log in yet
                $_SESSION['shared_key'] = $sharedKey;
                $_SESSION['username'] = $username;

                // Step 3: Generate and Email 2FA Code
                $twoFACode = random_int(100000, 999999); // 6-digit code
                $_SESSION['2fa_code'] = $twoFACode;
                $_SESSION['2fa_expiry'] = time() + 180; // Code valid for 5 minutes
                $_SESSION['waiting_for_2fa'] = true; // Set 2FA waiting flag

                // Send 2FA code via Gmail SMTP using PHPMailer
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'geniusassignments123@gmail.com'; // Your Gmail email
                $mail->Password = 'Pizza123*';    // Your Gmail app password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('geniusassignments123@gmail.com', 'Your Website');
                $mail->addAddress($row['email']); // User's email address
                $mail->Subject = 'Your 2FA Code';
                $mail->Body = "Your 2FA code is: $twoFACode";

                if ($mail->send()) {
                    // Redirect to 2FA verification page
                    header('Location: 2fa_verify.php'); 
                    exit();
                } else {
                    $errors['2fa'] = "Failed to send 2FA code. Please try again.";
                    session_unset();
                    session_destroy();
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
