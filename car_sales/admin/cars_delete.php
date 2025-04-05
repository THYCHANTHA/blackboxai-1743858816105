<?php
// Car Deletion Handler
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Security check - admin only
if(!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Validate car ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = 'Invalid car ID';
    header('Location: cars.php');
    exit;
}

$car_id = (int)$_GET['id'];

// In a production environment, you would:
// 1. Verify the car exists
// 2. Handle any related data (images, documents, etc.)
// 3. Perform the deletion in a transaction
// 4. Provide proper error handling

// For demo purposes, we'll simulate a successful deletion
$_SESSION['success'] = 'Car #' . $car_id . ' has been deleted';

// Redirect back to cars listing
header('Location: cars.php');
exit;
?>