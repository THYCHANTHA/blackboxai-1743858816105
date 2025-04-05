<?php
require_once __DIR__ . '/config.php';

/**
 * Register a new user
 * @param string $username
 * @param string $email 
 * @param string $password
 * @param string $full_name
 * @param string $phone
 * @return bool True on success, false on failure
 */
function registerUser($username, $email, $password, $full_name, $phone) {
    global $conn;
    
    // Validate input
    if(empty($username) || empty($email) || empty($password) || empty($full_name)) {
        return false;
    }
    
    // Check if user already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    
    if($stmt->num_rows > 0) {
        $stmt->close();
        return false;
    }
    $stmt->close();
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $full_name, $phone);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}

/**
 * Authenticate a user
 * @param string $username
 * @param string $password
 * @return array|bool User data on success, false on failure
 */
function loginUser($username, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id, username, email, password, full_name, role FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if(password_verify($password, $user['password'])) {
            // Remove password before returning
            unset($user['password']);
            return $user;
        }
    }
    
    return false;
}

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is admin
 * @return bool
 */
function isAdmin() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
}

/**
 * Logout the current user
 */
function logout() {
    // Unset all session variables
    $_SESSION = array();
    
    // Delete session cookie
    if(ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy session
    session_destroy();
}

/**
 * Get current user data
 * @return array|null
 */
function getCurrentUser() {
    if(!isLoggedIn()) return null;
    
    global $conn;
    $stmt = $conn->prepare("SELECT id, username, email, full_name, phone, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows === 1 ? $result->fetch_assoc() : null;
}

/**
 * Update user profile
 * @param int $user_id
 * @param string $full_name
 * @param string $phone
 * @param string $email
 * @return bool
 */
function updateProfile($user_id, $full_name, $phone, $email) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, phone = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $full_name, $phone, $email, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}

/**
 * Change user password
 * @param int $user_id
 * @param string $current_password
 * @param string $new_password
 * @return bool
 */
function changePassword($user_id, $current_password, $new_password) {
    global $conn;
    
    // Verify current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if(password_verify($current_password, $user['password'])) {
            $new_hashed = password_hash($new_password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $new_hashed, $user_id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
    }
    
    return false;
}

/**
 * Initiate password reset
 * @param string $email
 * @return bool
 */
function initiatePasswordReset($email) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user['id'], $token, $expires);
        $result = $stmt->execute();
        $stmt->close();
        
        if($result) {
            // In a real app, you would send an email with the reset link
            return $token;
        }
    }
    
    return false;
}

/**
 * Complete password reset
 * @param string $token
 * @param string $new_password
 * @return bool
 */
function completePasswordReset($token, $new_password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT user_id FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1) {
        $reset = $result->fetch_assoc();
        $new_hashed = password_hash($new_password, PASSWORD_BCRYPT);
        
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_hashed, $reset['user_id']);
        $result = $stmt->execute();
        $stmt->close();
        
        if($result) {
            // Delete the used token
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    }
    
    return false;
}
?>