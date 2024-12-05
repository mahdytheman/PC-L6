<?php
// Connection
include('config/db_connect.php');
require 'vendor/autoload.php'; // Ensure OTPHP and Endroid libraries are loaded

use OTPHP\TOTP;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\RoundBlockSizeMode;

// Essential Variables
$errors = ["username" => "", "email" => ""];
$username = $email = $password = $hashedPass = $salt = $secret = "";
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
        $salt = bin2hex(random_bytes(16)); // Generate a salt
        $hashedPass = password_hash($salt . $password, PASSWORD_DEFAULT); // Combine salt with password and hash
        $password_valid = true;
    }

    // Generate TOTP Secret and Save User
    if ($password_valid && $email_valid && $username_valid) {
        $totp = TOTP::create(); // Generate TOTP
        $secret = $totp->getSecret();

        // Save user data to database
        $sql = "INSERT INTO accounts (username, email, password, salt, secret) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedPass, $salt, $secret);

        if (mysqli_stmt_execute($stmt)) {
            // Generate the provisioning URI
            $totp->setLabel($username);
            $totp->setIssuer('Pizza Store');
            $provisioningUri = $totp->getProvisioningUri();

            // Create QR code
            $qrCode = new QrCode(
                data: $provisioningUri,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::High, // Direct enum usage
                size: 300,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin,
                foregroundColor: new Color(0, 0, 0), // Black foreground
                backgroundColor: new Color(255, 255, 255) // White background
            );

            // Add a label to the QR code
            $label = new Label(
                text: 'Scan with Authenticator',
                textColor: new Color(255, 0, 0) // Red text
            );

            // Create PNG writer
            $writer = new PngWriter();

            // Generate and save the QR code
            $qrCodePath = __DIR__ . '/qrcodes/' . $username . '_qrcode.png';
            $result = $writer->write($qrCode, null, $label); // Pass `null` instead of a logo
            $result->saveToFile($qrCodePath);

            // Display the QR code on the page
            echo "<p>Scan this QR code with Microsoft Authenticator:</p>";
            echo "<img src='/PC-L6/includes/qrcodes/" . $username . "_qrcode.png' alt='QR Code'>";
            exit();
        } else {
            echo "ERROR: " . mysqli_error($conn);
        }
    }
}

// Additional cleanup if needed
mysqli_close($conn);
?>
