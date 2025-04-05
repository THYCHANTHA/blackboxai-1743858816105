<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if(!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Sample data (replace with DB query)
$cars = [
    [
        'id' => 1,
        'make' => 'Toyota',
        'model' => 'Camry',
        'year' => 2020,
        'price' => 25000,
        'status' => 'pending',
        'created_at' => '2023-06-01'
    ],
    [
        'id' => 2,
        'make' => 'Honda',
        'model' => 'Civic',
        'year' => 2019,
        'price' => 22000,
        'status' => 'approved',
        'created_at' => '2023-05-15'
    ]
];

$page_title = "My Cars | " . SITE_NAME;
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">My Car Listings</h1>
    
    <?php if(empty($cars)): ?>
        <div class="bg-white shadow rounded-lg p-6 text-center">
            <p class="mb-4">You haven't listed any cars yet.</p>
            <a href="add_car.php" class="btn-primary">
                Add Your First Car
            </a>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">Car</th>
                        <th class="px-6 py-3 text-left">Price</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Date</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cars as $car): ?>
                    <tr class="border-b">
                        <td class="px-6 py-4">
                            <?= htmlspecialchars($car['make'].' '.$car['model'].' ('.$car['year'].')') ?>
                        </td>
                        <td class="px-6 py-4">
                            $<?= number_format($car['price']) ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="status-badge <?= $car['status'] ?>">
                                <?= ucfirst($car['status']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?= date('M j, Y', strtotime($car['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="car-details.php?id=<?= $car['id'] ?>" class="text-blue-600 mr-3">View</a>
                            <a href="edit_car.php?id=<?= $car['id'] ?>" class="text-blue-600 mr-3">Edit</a>
                            <a href="delete_car.php?id=<?= $car['id'] ?>" class="text-red-600" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>