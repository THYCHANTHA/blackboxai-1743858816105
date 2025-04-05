<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Redirect if not admin
if(!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Set page title
$page_title = "Manage Cars | " . SITE_NAME;

// Custom admin header
$admin_header = true;
require_once __DIR__ . '/../../includes/header.php';

// Sample car data (in a real app, this would come from database)
$cars = [
    [
        'id' => 1,
        'make' => 'Porsche',
        'model' => '911 Turbo S',
        'year' => 2023,
        'price' => 203500,
        'mileage' => 1200,
        'color' => 'GT Silver Metallic',
        'vin' => 'WP0AB2A99PS123456',
        'status' => 'available'
    ],
    [
        'id' => 2,
        'make' => 'Mercedes-Benz',
        'model' => 'S-Class',
        'year' => 2023,
        'price' => 114000,
        'mileage' => 3500,
        'color' => 'Obsidian Black',
        'vin' => 'WDD22222222222222',
        'status' => 'available'
    ],
    [
        'id' => 3,
        'make' => 'Tesla',
        'model' => 'Model S Plaid',
        'year' => 2023,
        'price' => 135000,
        'mileage' => 1500,
        'color' => 'Pearl White',
        'vin' => '5YJSA11111111111',
        'status' => 'pending'
    ]
];
?>

<div class="min-h-full">
    <?php include __DIR__ . '/nav.php'; ?>

    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Car Inventory Management</h1>
                <a href="cars_add.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i> Add New Car
                </a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Make/Model
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Year
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Price
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach($cars as $car): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" src="https://logo.clearbit.com/<?php echo urlencode($car['make']); ?>.com" onerror="this.src='https://via.placeholder.com/40'" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <?php echo htmlspecialchars($car['make']); ?> <?php echo htmlspecialchars($car['model']); ?>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            VIN: <?php echo htmlspecialchars($car['vin']); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($car['year']); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">$<?php echo number_format($car['price'], 0); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php 
                                                    echo $car['status'] === 'available' ? 'bg-green-100 text-green-800' : 
                                                    ($car['status'] === 'sold' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); 
                                                ?>">
                                                    <?php echo ucfirst($car['status']); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="../../public/car-details.php?id=<?php echo $car['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3" target="_blank">View</a>
                                                <a href="cars_edit.php?id=<?php echo $car['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                                <a href="cars_delete.php?id=<?php echo $car['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this car?')">Delete</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>