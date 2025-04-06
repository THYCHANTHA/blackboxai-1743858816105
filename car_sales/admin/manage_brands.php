<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new brand
    if (isset($_POST['add_brand'])) {
        $name = trim($_POST['name']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        
        // Handle logo upload
        if (!empty($_FILES['logo']['name'])) {
            $upload_dir = __DIR__ . '/../../uploads/brands/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $file_ext;
            $target_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_path)) {
                $logo_path = '/uploads/brands/' . $file_name;
                $stmt = $conn->prepare("INSERT INTO car_brands (name, logo_path, is_featured) VALUES (?, ?, ?)");
                $stmt->bind_param("ssi", $name, $logo_path, $is_featured);
                $stmt->execute();
            }
        }
    }
    // Delete brand
    elseif (isset($_POST['delete_brand'])) {
        $brand_id = (int)$_POST['brand_id'];
        $stmt = $conn->prepare("DELETE FROM car_brands WHERE id = ?");
        $stmt->bind_param("i", $brand_id);
        $stmt->execute();
    }
}

// Get all brands
$brands = $conn->query("SELECT * FROM car_brands ORDER BY name")->fetch_all(MYSQLI_ASSOC);

$page_title = "Manage Brands";
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/nav.php';
?>

<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Manage Car Brands</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Add Brand Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Add New Brand</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Brand Name*</label>
                    <input type="text" name="name" required class="w-full input-field">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Brand Logo*</label>
                    <input type="file" name="logo" accept="image/*" required class="w-full">
                </div>
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_featured" class="form-checkbox">
                        <span class="ml-2">Featured on homepage</span>
                    </label>
                </div>
                <button type="submit" name="add_brand" class="btn-primary">Add Brand</button>
            </form>
        </div>
        
        <!-- Brands List -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">All Brands (<?= count($brands) ?>)</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Logo</th>
                            <th class="text-left py-2">Name</th>
                            <th class="text-left py-2">Featured</th>
                            <th class="text-left py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($brands as $brand): ?>
                        <tr class="border-b">
                            <td class="py-3">
                                <?php if($brand['logo_path']): ?>
                                    <img src="<?= $brand['logo_path'] ?>" alt="<?= $brand['name'] ?>" class="h-10">
                                <?php endif; ?>
                            </td>
                            <td class="py-3"><?= $brand['name'] ?></td>
                            <td class="py-3">
                                <?php if($brand['is_featured']): ?>
                                    <span class="text-green-500">✓</span>
                                <?php else: ?>
                                    <span class="text-gray-400">✗</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3">
                                <form method="POST" onsubmit="return confirm('Delete this brand?')">
                                    <input type="hidden" name="brand_id" value="<?= $brand['id'] ?>">
                                    <button type="submit" name="delete_brand" class="text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>