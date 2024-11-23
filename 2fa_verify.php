<?php
session_start();

// Check if user is waiting for 2FA
if (empty($_SESSION['waiting_for_2fa']) || $_SESSION['waiting_for_2fa'] !== true) {
    header('Location: login.php'); // If 2FA is not required, redirect to login
    exit();
}

$errors = ["2fa" => ""];

if (isset($_POST['verify_2fa'])) {
    $inputCode = $_POST['2fa_code'];
    if ($inputCode == $_SESSION['2fa_code']) {
        // 2FA code is correct, log the user in
        $_SESSION['logged_in'] = true;
        unset($_SESSION['waiting_for_2fa']); // Remove 2FA waiting flag
        unset($_SESSION['2fa_code']); // Remove the 2FA code

        // Redirect to the main page (after successful login)
        header('Location: index_menu.php');
        exit();
    } else {
        $errors['2fa'] = "Incorrect 2FA code!";
    }
}
?>

<form action="2fa_verify.php" method="POST">
    <input type="text" name="2fa_code" placeholder="Enter 2FA code" required>
    <input type="submit" name="verify_2fa" value="Verify">
</form>

<?php if (!empty($errors['2fa'])): ?>
    <p style="color: red;"><?php echo $errors['2fa']; ?></p>
<?php endif; ?>
