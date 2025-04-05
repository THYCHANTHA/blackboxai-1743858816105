<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Start session if not already started
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if form was submitted
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validate input
    if(empty($username) || empty($password)) {
        $_SESSION['error'] = 'Please enter both username and password';
        header('Location: login.php');
        exit;
    }
    
    // Check credentials
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? AND role = 'admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if(password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Check if remember me was checked
            if(isset($_POST['remember-me'])) {
                // Create remember token (valid for 30 days)
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
                
                $stmt = $conn->prepare("UPDATE users SET remember_token = ?, token_expires = ? WHERE id = ?");
                $stmt->bind_param("ssi", $token, $expires, $user['id']);
                $stmt->execute();
                
                // Set cookie (valid for 30 days)
                setcookie('remember', $token, time() + (30 * 24 * 60 * 60), '/');
            }
            
            // Redirect to admin dashboard
            header('Location: index.php');
            exit;
        }
    }
    
    // If we get here, authentication failed
    $_SESSION['error'] = 'Invalid username or password';
    header('Location: login.php');
    exit;
} else {
    // If not POST request, redirect to login
    header('Location: login.php');
    exit;
}
?>