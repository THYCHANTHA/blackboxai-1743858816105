<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if(!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Validate car ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: my_cars.php');
    exit;
}

$car_id = (int)$_GET['id'];

// In production:
// 1. Verify car belongs to user
// 2. Delete from database
// 3. Handle any related data (images, etc.)

$_SESSION['success'] = 'Car listing deleted successfully';
header('Location: my_cars.php');
exit;
?>