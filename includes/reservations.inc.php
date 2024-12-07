<?php
// Database Connection
include('config/db_connect.php');

// Triple DES Encryption Settings
function generateEncryptionKey()
{
    return random_bytes(24); // Generate a random 24-byte key for Triple DES
}

function encryptData($data)
{
    $key = generateEncryptionKey(); // Generate a new key for each encryption
    $iv = random_bytes(openssl_cipher_iv_length('des-ede3-cbc'));
    $encrypted = openssl_encrypt($data, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return ['data' => $encrypted, 'iv' => $iv, 'key' => $key];
}

// Check Reservation Availability
function isTimeAvailable($conn, $date, $time)
{
    $stmt = $conn->prepare("SELECT COUNT(*) FROM reservations WHERE reservation_date = ? AND reservation_time = ?");
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count === 0;
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_date = $_POST['date'];
    $reservation_time = $_POST['time'];
    $file = $_FILES['id_image'];

    // Check for file upload errors
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Read the first few bytes to check magic bytes
        $fileContent = file_get_contents($file['tmp_name']);
        $magicBytes = bin2hex(substr($fileContent, 0, 4));
        $validMagicBytes = ['ffd8ffe0', 'ffd8ffe1', '89504e47']; // JPEG, JPEG EXIF, PNG

        if (in_array($magicBytes, $validMagicBytes)) {
            // Check availability
            if (isTimeAvailable($conn, $reservation_date, $reservation_time)) {
                // Encrypt ID Image
                $encryptedData = encryptData($fileContent);
                $encryptedID = $encryptedData['data'];
                $iv = $encryptedData['iv'];
                $encryptionKey = $encryptedData['key'];

                // Store Reservation in Database
                $stmt = $conn->prepare("INSERT INTO reservations (reservation_date, reservation_time, id_image, iv, encryption_key) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $reservation_date, $reservation_time, $encryptedID, $iv, $encryptionKey);

                if ($stmt->execute()) {
                    echo "Reservation successful!";
                } else {
                    echo "Failed to save reservation: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "The selected time is not available. Please choose a different time.";
            }
        } else {
            echo "Invalid ID image format. Only JPEG and PNG are allowed.";
        }
    } else {
        echo "Error uploading file: " . $file['error'];
    }
}

// Close Database Connection
$conn->close();
?>
