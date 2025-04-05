<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$errors = [];
$success = false;
$verification_via = $_GET['via'] ?? 'email'; // 'email' or 'phone'

// Check if user came from registration
if (isset($_SESSION['verification_email'])) {
    $email = $_SESSION['verification_email'];
} elseif (isset($_SESSION['verification_phone'])) {
    $phone = $_SESSION['verification_phone'];
} else {
    header('Location: register_new.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verification_code = trim($_POST['verification_code'] ?? '');
    
    if (empty($verification_code)) {
        $errors[] = 'Verification code is required';
    } else {
        if ($verification_via === 'email') {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND verification_code = ? AND verification_expiry > NOW()");
            $stmt->bind_param("ss", $email, $verification_code);
        } else {
            $stmt = $conn->prepare("SELECT id FROM users WHERE phone = ? AND verification_code = ? AND verification_expiry > NOW()");
            $stmt->bind_param("ss", $phone, $verification_code);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user_id = $result->fetch_assoc()['id'];
            
            // Mark user as verified
            $stmt = $conn->prepare("UPDATE users SET verification_code = NULL, verification_expiry = NULL, verified_at = NOW() WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            
            $success = true;
            unset($_SESSION['verification_email']);
            unset($_SESSION['verification_phone']);
        } else {
            $errors[] = 'Invalid or expired verification code';
        }
    }
}

$page_title = "Verify Account | " . SITE_NAME;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="max-w-md mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Verify Your Account</h1>
        
        <?php if(!empty($errors)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                <?php foreach($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                <p>Account verified successfully! You can now login.</p>
            </div>
            <div class="text-center">
                <a href="login.php" class="btn-primary">Go to Login</a>
            </div>
        <?php else: ?>
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Verification Code*</label>
                    <input type="text" name="verification_code" required class="w-full input-field" placeholder="Enter 6-digit code">
                    <p class="text-xs text-gray-500 mt-1">
                        <?= $verification_via === 'email' ? 
                            'Check your email for the verification code' : 
                            'Check your phone for the verification code' ?>
                    </p>
                </div>

                <button type="submit" class="btn-primary w-full">Verify Account</button>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm">Didn't receive code? <a href="resend_verification.php" class="text-blue-600">Resend code</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>