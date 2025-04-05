<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Redirect if not admin
if(!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Check if car ID is provided
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: cars.php');
    exit;
}

$car_id = (int)$_GET['id'];

// Get car data (in a real app, this would come from database)
$car = [
    'id' => $car_id,
    'make' => 'Porsche',
    'model' => '911 Turbo S',
    'year' => 2023,
    'price' => 203500,
    'mileage' => 1200,
    'color' => 'GT Silver Metallic',
    'vin' => 'WP0AB2A99PS123456',
    'status' => 'available',
    'description' => 'Fully loaded with premium package'
];

// Set page title
$page_title = "Edit Car | " . SITE_NAME;

// Custom admin header
$admin_header = true;
require_once __DIR__ . '/../../includes/header.php';

// Process form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = trim($_POST['make'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $mileage = trim($_POST['mileage'] ?? '');
    $color = trim($_POST['color'] ?? '');
    $vin = trim($_POST['vin'] ?? '');
    $status = trim($_POST['status'] ?? 'available');
    $description = trim($_POST['description'] ?? '');
    
    // Validate input
    $errors = [];
    
    if(empty($make)) $errors[] = 'Make is required';
    if(empty($model)) $errors[] = 'Model is required';
    if(empty($year) || !is_numeric($year)) $errors[] = 'Valid year is required';
    if(empty($price) || !is_numeric($price)) $errors[] = 'Valid price is required';
    if(empty($mileage) || !is_numeric($mileage)) $errors[] = 'Valid mileage is required';
    if(empty($vin)) $errors[] = 'VIN is required';
    
    if(empty($errors)) {
        // In a real app, you would update the database here
        $_SESSION['success'] = 'Car updated successfully';
        header('Location: cars.php');
        exit;
    }
}
?>

<div class="min-h-full">
    <?php include __DIR__ . '/nav.php'; ?>

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit Car: <?php echo htmlspecialchars($car['make'] . ' ' . $car['model']); ?></h1>
                <a href="cars.php" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Inventory
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
                                <label for="make" class="block text-sm font-medium text-gray-700">Make*</label>
                                <input type="text" name="make" id="make" value="<?php echo htmlspecialchars($car['make']); ?>" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="model" class="block text-sm font-medium text-gray-700">Model*</label>
                                <input type="text" name="model" id="model" value="<?php echo htmlspecialchars($car['model']); ?>" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="year" class="block text-sm font-medium text-gray-700">Year*</label>
                                <input type="number" name="year" id="year" min="1900" max="<?php echo date('Y')+1; ?>" value="<?php echo htmlspecialchars($car['year']); ?>" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="price" class="block text-sm font-medium text-gray-700">Price*</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="price" id="price" min="0" step="0.01" value="<?php echo htmlspecialchars($car['price']); ?>" required
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="mileage" class="block text-sm font-medium text-gray-700">Mileage*</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" name="mileage" id="mileage" min="0" value="<?php echo htmlspecialchars($car['mileage']); ?>" required
                                        class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">mi</span>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                                <input type="text" name="color" id="color" value="<?php echo htmlspecialchars($car['color']); ?>"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="vin" class="block text-sm font-medium text-gray-700">VIN*</label>
                                <input type="text" name="vin" id="vin" value="<?php echo htmlspecialchars($car['vin']); ?>" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status*</label>
                                <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="available" <?php echo $car['status'] === 'available' ? 'selected' : ''; ?>>Available</option>
                                    <option value="pending" <?php echo $car['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="sold" <?php echo $car['status'] === 'sold' ? 'selected' : ''; ?>>Sold</option>
                                </select>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea id="description" name="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo htmlspecialchars($car['description']); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Car
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