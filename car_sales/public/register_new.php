<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $register_via = $_POST['register_via'] ?? 'email';

    // Validate inputs
    if (empty($username)) $errors[] = 'Username is required';
    if (empty($password)) $errors[] = 'Password is required';
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match';
    
    if ($register_via === 'email') {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }
    } else {
        // Validate Cambodia phone number
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (!preg_match('/^0[0-9]{8,9}$/', $phone)) {
            $errors[] = 'Valid Cambodia phone number required (10 digits starting with 0)';
        }
    }

    if (empty($errors)) {
        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = 'Username already taken';
        }

        // Check if email/phone exists
        if ($register_via === 'email') {
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
        } else {
            $stmt = $conn->prepare("SELECT id FROM users WHERE phone = ?");
            $stmt->bind_param("s", $phone);
        }
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = $register_via === 'email' ? 'Email already registered' : 'Phone number already registered';
        }

        if (empty($errors)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $verification_code = rand(100000, 999999);
            $verification_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password_hash, verification_code, verification_expiry) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $email, $phone, $password_hash, $verification_code, $verification_expiry);
            
            if ($stmt->execute()) {
                if ($register_via === 'email') {
                    // Send verification email
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
                    $mail->Subject = 'Verify Your Account';
                    $mail->Body = "Your verification code is: $verification_code";
                    
                    if ($mail->send()) {
                        $_SESSION['verification_email'] = $email;
                        header('Location: verify.php');
                        exit;
                    } else {
                        $errors[] = 'Failed to send verification email';
                    }
                } else {
                    // For phone verification (would need SMS API integration)
                    $_SESSION['verification_phone'] = $phone;
                    header('Location: verify.php?via=phone');
                    exit;
                }
            } else {
                $errors[] = 'Registration failed. Please try again.';
            }
        }
    }
}

$page_title = "Register | " . SITE_NAME;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="max-w-md mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6">Create Account</h1>
        
        <?php if(!empty($errors)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                <?php foreach($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Username*</label>
                <input type="text" name="username" required class="w-full input-field">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Password*</label>
                <input type="password" name="password" required class="w-full input-field">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Confirm Password*</label>
                <input type="password" name="confirm_password" required class="w-full input-field">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Register via*</label>
                <select name="register_via" id="register_via" class="w-full input-field">
                    <option value="email">Email</option>
                    <option value="phone">Phone (Cambodia)</option>
                </select>
            </div>

            <div id="email_field" class="mb-4">
                <label class="block text-sm font-medium mb-1">Email*</label>
                <input type="email" name="email" class="w-full input-field">
            </div>

            <div id="phone_field" class="mb-4 hidden">
                <label class="block text-sm font-medium mb-1">Phone Number* (Cambodia)</label>
                <input type="tel" name="phone" placeholder="0123456789" class="w-full input-field">
            </div>

            <button type="submit" class="btn-primary w-full">Register</button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm">Already have an account? <a href="login.php" class="text-blue-600">Login here</a></p>
        </div>
    </div>
</div>

<script>
document.getElementById('register_via').addEventListener('change', function() {
    const via = this.value;
    document.getElementById('email_field').classList.toggle('hidden', via !== 'email');
    document.getElementById('phone_field').classList.toggle('hidden', via !== 'phone');
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>