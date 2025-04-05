<?php
// Inquiry Detail View
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Admin authentication
if(!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Validate inquiry ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: inquiries.php');
    exit;
}

$inquiry_id = (int)$_GET['id'];

// Sample data structure
$inquiry = [
    'id' => $inquiry_id,
    'name' => 'John Smith',
    'email' => 'john@example.com',
    'phone' => '555-123-4567',
    'car' => 'Porsche 911 Turbo S',
    'message' => "I'm interested in scheduling a test drive for this vehicle. Please provide available time slots.",
    'status' => 'new',
    'created_at' => '2023-06-15 14:30:00'
];

// Page setup
$page_title = "Inquiry #$inquiry_id | " . SITE_NAME;
$admin_header = true;
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="min-h-full">
    <?php include __DIR__ . '/nav.php'; ?>

    <main class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Inquiry Details</h1>
            <a href="inquiries.php" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium">
                    <?= htmlspecialchars($inquiry['car']) ?>
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Received: <?= date('M j, Y g:i a', strtotime($inquiry['created_at'])) ?>
                </p>
            </div>

            <div class="px-4 py-5 sm:p-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Customer</h4>
                    <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inquiry['name']) ?></p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Email</h4>
                    <p class="mt-1 text-sm text-gray-900">
                        <a href="mailto:<?= htmlspecialchars($inquiry['email']) ?>" class="text-blue-600">
                            <?= htmlspecialchars($inquiry['email']) ?>
                        </a>
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                    <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inquiry['phone']) ?></p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Status</h4>
                    <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        <?= $inquiry['status'] === 'new' ? 'bg-blue-100 text-blue-800' : 
                           ($inquiry['status'] === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                        <?= ucfirst(str_replace('_', ' ', $inquiry['status'])) ?>
                    </span>
                </div>
                <div class="sm:col-span-2">
                    <h4 class="text-sm font-medium text-gray-500">Message</h4>
                    <div class="mt-1 p-3 bg-gray-50 rounded-md">
                        <p class="text-sm text-gray-900 whitespace-pre-line"><?= htmlspecialchars($inquiry['message']) ?></p>
                    </div>
                </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="inquiry_update.php?id=<?= $inquiry_id ?>" class="btn-primary">
                    Update Status
                </a>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>