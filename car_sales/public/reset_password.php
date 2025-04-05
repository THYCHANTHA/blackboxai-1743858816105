<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$errors = [];
$success = false;
$valid_token = false;
$user_id = null;

// Check for token
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $valid_token = true;
        $user_id = $result->fetch_assoc()['id'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_token) {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($password)) $errors[] = 'Password is required';
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match';
    
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
        $stmt->bind_param("si", $password_hash, $user_id);
        
        if ($stmt->execute()) {
            $success = 'Password reset successfully. You can now login with your new password.';
        } else {
            $errors[] = 'Failed to reset password. Please try again.';
        }
    }
}

$page_title = "Reset Password | " . SITE_NAME;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="max-w-md mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Reset Password</h1>
        
        <?php if(!$valid_token): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                <p>Invalid or expired reset link. Please request a new password reset.</p>
            </div>
            <div class="mt-4 text-center">
                <a href="forgot_password.php" class="text-blue-600">Request new reset link</a>
            </div>
        <?php else: ?>
            <?php if(!empty($errors)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                    <?php foreach($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if($success): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    <p><?= htmlspecialchars($success) ?></p>
                </div>
                <div class="text-center">
                    <a href="login.php" class="btn-primary">Go to Login</a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">New Password*</label>
                        <input type="password" name="password" required class="w-full input-field">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Confirm Password*</label>
                        <input type="password" name="confirm_password" required class="w-full input-field">
                    </div>

                    <button type="submit" class="btn-primary w-full">Reset Password</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>