<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if(!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Get user data (in production, fetch from database)
$user = [
    'id' => $_SESSION['user_id'],
    'username' => 'john_doe',
    'email' => 'john@example.com',
    'phone' => '555-123-4567',
    'created_at' => '2023-01-15'
];

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    
    // Validate
    if(empty($username)) $errors[] = 'Username required';
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required';
    
    if(!empty($new_password) && empty($current_password)) {
        $errors[] = 'Current password required to change password';
    }
    
    if(empty($errors)) {
        // In production: Update database
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        
        $_SESSION['success'] = 'Profile updated';
        header('Location: account.php');
        exit;
    }
}

$page_title = "Edit Profile | " . SITE_NAME;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <?php include __DIR__ . '/account_sidebar.php'; ?>
        </div>
        
        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>
            
            <?php if(!empty($errors)): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <?php foreach($errors as $error): ?>
                        <p class="text-red-700"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-1">Username*</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required class="w-full input-field">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Email*</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required class="w-full input-field">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Phone</label>
                        <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" class="w-full input-field">
                    </div>
                    
                    <div class="border-t pt-4">
                        <h3 class="text-lg font-medium mb-4">Change Password</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Current Password</label>
                            <input type="password" name="current_password" class="w-full input-field">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">New Password</label>
                            <input type="password" name="new_password" class="w-full input-field">
                            <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="account.php" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>