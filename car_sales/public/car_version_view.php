<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if(!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Validate parameters
if(!isset($_GET['car_id']) || !is_numeric($_GET['car_id']) || 
   !isset($_GET['version']) || !is_numeric($_GET['version'])) {
    header('Location: my_cars.php');
    exit;
}

$car_id = (int)$_GET['car_id'];
$version = (int)$_GET['version'];

// Get current car details
$current_car = [];
$stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) {
    header('Location: my_cars.php');
    exit;
}
$current_car = $result->fetch_assoc();

// Get version details
$version_data = [];
$stmt = $conn->prepare("SELECT v.*, u.username FROM car_versions v JOIN users u ON v.changed_by = u.id WHERE v.car_id = ? AND v.version = ?");
$stmt->bind_param("ii", $car_id, $version);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) {
    header("Location: car_version_history.php?id=$car_id");
    exit;
}
$version_data = $result->fetch_assoc();

$page_title = "Version v$version Details | " . htmlspecialchars($current_car['make'].' '.$current_car['model']);
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">
            Version v<?= $version ?>: <?= htmlspecialchars($current_car['make'].' '.$current_car['model'].' ('.$current_car['year'].')') ?>
        </h1>
        <a href="car_version_history.php?id=<?= $car_id ?>" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to History
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="mb-4">
            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?= $version == $current_car['current_version'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                <?= $version == $current_car['current_version'] ? 'Current Version' : 'Past Version' ?>
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium mb-2">Version Details</h3>
                <div class="space-y-2">
                    <p><strong>Modified By:</strong> <?= htmlspecialchars($version_data['username']) ?></p>
                    <p><strong>Modified On:</strong> <?= date('M j, Y g:i a', strtotime($version_data['created_at'])) ?></p>
                    <p><strong>Change Reason:</strong> <?= htmlspecialchars($version_data['change_reason'] ?? 'No reason provided') ?></p>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-medium mb-2">Actions</h3>
                <div class="space-y-2">
                    <?php if($version != $current_car['current_version']): ?>
                        <a href="car_version_restore.php?car_id=<?= $car_id ?>&amp;version=<?= $version ?>" class="btn-primary inline-block" onclick="return confirm('Restore this version?')">
                            <i class="fas fa-history mr-2"></i> Restore This Version
                        </a>
                    <?php endif; ?>
                    <a href="car-details.php?id=<?= $car_id ?>" class="btn-secondary inline-block">
                        <i class="fas fa-car mr-2"></i> View Current Version
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4">Car Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="font-medium">Make: <?= htmlspecialchars($version_data['make']) ?></p>
                    <p class="font-medium">Model: <?= htmlspecialchars($version_data['model']) ?></p>
                    <p>Year: <?= htmlspecialchars($version_data['year']) ?></p>
                    <p>Color: <?= htmlspecialchars($version_data['color'] ?? 'N/A') ?></p>
                </div>
                <div>
                    <p class="font-medium">Price: $<?= number_format($version_data['price'], 2) ?></p>
                    <p>Mileage: <?= number_format($version_data['mileage']) ?> miles</p>
                    <p>VIN: <?= htmlspecialchars($version_data['vin'] ?? 'N/A') ?></p>
                </div>
            </div>
            
            <div class="mt-6">
                <h3 class="font-medium mb-2">Description:</h3>
                <div class="prose max-w-none">
                    <?= nl2br(htmlspecialchars($version_data['description'] ?? 'No description provided')) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>