<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Admin authentication check
if(!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Set page metadata
$page_title = "Manage Inquiries | " . SITE_NAME;
$admin_header = true;
require_once __DIR__ . '/../../includes/header.php';

// Sample inquiry data (in production, this would come from database)
$inquiries = [
    [
        'id' => 1,
        'name' => 'John Smith',
        'email' => 'john@example.com',
        'phone' => '(555) 123-4567',
        'car_id' => 1,
        'car_make' => 'Porsche',
        'car_model' => '911 Turbo S',
        'message' => 'Interested in test drive. When are you available?',
        'status' => 'new',
        'created_at' => '2023-06-15 10:30:00'
    ],
    [
        'id' => 2,
        'name' => 'Sarah Johnson',
        'email' => 'sarah@example.com',
        'phone' => '(555) 987-6543',
        'car_id' => 2,
        'car_make' => 'Tesla',
        'car_model' => 'Model S Plaid',
        'message' => 'Would like to discuss financing options',
        'status' => 'in_progress',
        'created_at' => '2023-06-14 14:15:00'
    ]
];
?>

<div class="min-h-full">
    <?php include __DIR__ . '/nav.php'; ?>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Customer Inquiries</h1>
            <div class="flex space-x-2">
                <select id="status-filter" class="border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All Statuses</option>
                    <option value="new">New</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                </select>
                <button id="export-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-download mr-2"></i> Export
                </button>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach($inquiries as $inquiry): ?>
                        <tr class="inquiry-row" data-status="<?= $inquiry['status'] ?>">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                        <?= strtoupper(substr($inquiry['name'], 0, 1)) ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($inquiry['name']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($inquiry['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($inquiry['car_make'] . ' ' . $inquiry['car_model']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate" title="<?= htmlspecialchars($inquiry['message']) ?>">
                                    <?= htmlspecialchars($inquiry['message']) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $inquiry['status'] === 'new' ? 'bg-blue-100 text-blue-800' : 
                                       ($inquiry['status'] === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                                    <?= ucfirst(str_replace('_', ' ', $inquiry['status'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y g:i a', strtotime($inquiry['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="inquiry_view.php?id=<?= $inquiry['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                <a href="inquiry_update.php?id=<?= $inquiry['id'] ?>" class="text-blue-600 hover:text-blue-900">Update</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
// Simple client-side filtering
document.getElementById('status-filter').addEventListener('change', function() {
    const status = this.value;
    document.querySelectorAll('.inquiry-row').forEach(row => {
        if(status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>