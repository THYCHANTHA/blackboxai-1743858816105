<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Redirect if not admin
if(!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Check if user ID is provided
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: users.php');
    exit;
}

$user_id = (int)$_GET['id'];

// Get user data
$user = null;
$stmt = $conn->prepare("SELECT id, username, email, full_name, phone, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    header('Location: users.php');
    exit;
}

// Set page title
$page_title = "Edit User | " . SITE_NAME;

// Custom admin header
$admin_header = true;
require_once __DIR__ . '/../../includes/header.php';

// Process form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = trim($_POST['role'] ?? 'user');
    
    // Validate input
    $errors = [];
    
    if(empty($username)) $errors[] = 'Username is required';
    if(empty($email)) $errors[] = 'Email is required';
    if(empty($full_name)) $errors[] = 'Full name is required';
    
    // Only validate password if provided
    if(!empty($password)) {
        if($password !== $confirm_password) $errors[] = 'Passwords do not match';
        if(strlen($password) < 8) $errors[] = 'Password must be at least 8 characters';
    }
    
    if(empty($errors)) {
        // Check if username/email already exists for another user
        $stmt = $conn->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->bind_param("ssi", $username, $email, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $errors[] = 'Username or email already exists';
        } else {
            // Update user
            if(!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ?, full_name = ?, phone = ?, role = ? WHERE id = ?");
                $stmt->bind_param("ssssssi", $username, $email, $hashed_password, $full_name, $phone, $role, $user_id);
            } else {
                $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, full_name = ?, phone = ?, role = ? WHERE id = ?");
                $stmt->bind_param("sssssi", $username, $email, $full_name, $phone, $role, $user_id);
            }
            
            if($stmt->execute()) {
                $_SESSION['success'] = 'User updated successfully';
                header('Location: users.php');
                exit;
            } else {
                $errors[] = 'Error updating user: ' . $conn->error;
            }
        }
    }
}
?>

<div class="min-h-full">
    <?php include __DIR__ . '/nav.php'; ?>

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit User: <?php echo htmlspecialchars($user['username']); ?></h1>
                <a href="users.php" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Users
                </a>
            </div>

            <?php if(!empty($errors)): ?>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <?php foreach($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form method="POST" class="divide-y divide-gray-200">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                                <input type="password" name="password" id="password"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" name="confirm_password" id="confirm_password"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select id="role" name="role" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>