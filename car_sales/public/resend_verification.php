<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Check if user has pending verification
if (!isset($_SESSION['verification_email']) && !isset($_SESSION['verification_phone'])) {
    header('Location: register_new.php');
    exit;
}

$verification_via = isset($_SESSION['verification_email']) ? 'email' : 'phone';
$email = $_SESSION['verification_email'] ?? null;
$phone = $_SESSION['verification_phone'] ?? null;

// Generate new verification code
$verification_code = rand(100000, 999999);
$verification_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

// Update verification code in database
if ($verification_via === 'email') {
    $stmt = $conn->prepare("UPDATE users SET verification_code = ?, verification_expiry = ? WHERE email = ?");
    $stmt->bind_param("sss", $verification_code, $verification_expiry, $email);
} else {
    $stmt = $conn->prepare("UPDATE users SET verification_code = ?, verification_expiry = ? WHERE phone = ?");
    $stmt->bind_param("sss", $verification_code, $verification_expiry, $phone);
}
$stmt->execute();

// Resend the verification code
if ($verification_via === 'email') {
    require_once __DIR__ . '/../includes/PHPMailer/PHPMailer.php';
    require_once __DIR__ . '/../includes/PHPMailer/SMTP.php';
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'chantha99ms@gmail.com';
    $mail->Password = 'gyjf uojr goxg oaoh';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    $mail->setFrom('noreply@carsales.com', 'Car Sales');
    $mail->addAddress($email);
    $mail->Subject = 'New Verification Code';
    $mail->Body = "Your new verification code is: $verification_code";
    
    if ($mail->send()) {
        $_SESSION['success'] = 'New verification code sent to your email';
    } else {
        $_SESSION['error'] = 'Failed to send verification email';
    }
} else {
    // For phone verification (would need SMS API integration)
    $_SESSION['success'] = 'New verification code sent to your phone';
}

header('Location: verify.php?via=' . $verification_via);
exit;
?>