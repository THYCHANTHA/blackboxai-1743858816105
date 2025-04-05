<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Admin check
if(!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Validate ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: inquiries.php');
    exit;
}

$inquiry_id = (int)$_GET['id'];

// Sample data
$inquiry = [
    'id' => $inquiry_id,
    'name' => 'John Smith',
    'car' => 'Porsche 911 Turbo S',
    'status' => 'new',
    'notes' => ''
];

// Handle form submit
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? '';
    $notes = $_POST['notes'] ?? '';
    
    // Validate
    if(in_array($status, ['new', 'in_progress', 'resolved'])) {
        // In real app: Update database
        $_SESSION['success'] = 'Inquiry updated';
        header('Location: inquiry_view.php?id='.$inquiry_id);
        exit;
    } else {
        $_SESSION['error'] = 'Invalid status';
    }
}

// Page setup
$page_title = "Update Inquiry | " . SITE_NAME;
$admin_header = true;
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="min-h-full">
    <?php include __DIR__ . '/nav.php'; ?>

    <main class="max-w-3xl mx-auto py-6 sm:px-6">
        <h1 class="text-2xl font-bold mb-6">Update Inquiry #<?= $inquiry_id ?></h1>
        
        <div class="bg-white shadow rounded-lg">
            <form method="POST" class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" class="w-full border rounded p-2">
                        <option value="new" <?= $inquiry['status'] === 'new' ? 'selected' : '' ?>>New</option>
                        <option value="in_progress" <?= $inquiry['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="resolved" <?= $inquiry['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Notes</label>
                    <textarea name="notes" rows="4" class="w-full border rounded p-2"><?= htmlspecialchars($inquiry['notes']) ?></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="inquiry_view.php?id=<?= $inquiry_id ?>" class="px-4 py-2 border rounded">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>