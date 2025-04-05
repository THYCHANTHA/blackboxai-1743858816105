<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Require login
if(!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Get user data
$user = getUserData($_SESSION['user_id']);

// Get user's listed cars
$user_cars = [];
$stmt = $conn->prepare("SELECT * FROM cars WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if($result) {
    $user_cars = $result->fetch_all(MYSQLI_ASSOC);
}

$page_title = "My Account | " . SITE_NAME;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-2xl font-bold">
                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold"><?= htmlspecialchars($user['username']) ?></h2>
                        <p class="text-gray-500">Member since <?= date('M Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>
                
                <nav class="space-y-2">
                    <a href="account.php" class="block px-4 py-2 bg-blue-100 text-blue-700 rounded-lg">My Profile</a>
                    <a href="my_cars.php" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">My Car Listings</a>
                    <a href="add_car.php" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">Add New Car</a>
                    <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100 rounded-lg">Logout</a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">My Account</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Account Information</h3>
                        <p class="text-gray-600"><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                        <p class="text-gray-600"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                        <p class="text-gray-600"><strong>Phone:</strong> <?= htmlspecialchars($user['phone'] ?? 'Not provided') ?></p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-2">My Listings</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-3xl font-bold"><?= count($user_cars) ?></p>
                            <p class="text-gray-600">Active car listings</p>
                            <a href="my_cars.php" class="text-blue-600 hover:underline mt-2 inline-block">View all</a>
                        </div>
                    </div>
                </div>
                
                <a href="edit_profile.php" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>