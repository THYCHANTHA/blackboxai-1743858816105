<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

if(!isAdmin()) {
    header('Location: /admin/login.php');
    exit;
}

// Check if new article or editing existing
$is_new = !isset($_GET['id']);
$article = [
    'id' => 0,
    'title' => '',
    'content' => '',
    'category' => 'selling',
    'status' => 'draft'
];

if(!$is_new) {
    $article_id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM knowledgebase WHERE id = ?");
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $article = $result->fetch_assoc();
    } else {
        header('Location: /admin/knowledgebase.php');
        exit;
    }
}

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category = trim($_POST['category'] ?? 'selling');
    $status = trim($_POST['status'] ?? 'draft');
    $change_reason = trim($_POST['change_reason'] ?? '');

    // Validate input
    if(empty($title)) $errors[] = 'Title is required';
    if(empty($content)) $errors[] = 'Content is required';
    if(!in_array($category, ['selling', 'buying', 'general'])) $errors[] = 'Invalid category';
    if(!in_array($status, ['draft', 'published', 'archived'])) $errors[] = 'Invalid status';
    if(empty($change_reason) && !$is_new) $errors[] = 'Please provide a reason for changes';

    if(empty($errors)) {
        if($is_new) {
            // Create new article
            $stmt = $conn->prepare("INSERT INTO knowledgebase (title, content, category, status, created_by) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $title, $content, $category, $status, $_SESSION['user_id']);
            $stmt->execute();
            $article_id = $conn->insert_id;
            
            // Create initial version
            $stmt = $conn->prepare("INSERT INTO knowledgebase_versions (article_id, version, title, content, category, changed_by, change_reason) VALUES (?, 1, ?, ?, ?, ?, 'Initial version')");
            $stmt->bind_param("isssi", $article_id, $title, $content, $category, $_SESSION['user_id']);
            $stmt->execute();
            
            $_SESSION['success'] = 'Article created successfully';
        } else {
            // Save current version before updating
            $new_version = $article['current_version'] + 1;
            $stmt = $conn->prepare("INSERT INTO knowledgebase_versions (article_id, version, title, content, category, changed_by, change_reason) 
                                  SELECT id, ?, title, content, category, ?, ? FROM knowledgebase WHERE id = ?");
            $stmt->bind_param("iisi", $new_version, $_SESSION['user_id'], $change_reason, $article['id']);
            $stmt->execute();
            
            // Update article
            $stmt = $conn->prepare("UPDATE knowledgebase SET title = ?, content = ?, category = ?, status = ?, current_version = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->bind_param("ssssii", $title, $content, $category, $status, $new_version, $article['id']);
            $stmt->execute();
            
            $_SESSION['success'] = 'Article updated successfully';
        }
        
        header("Location: /admin/knowledgebase.php");
        exit;
    }
}

$page_title = ($is_new ? "New Article" : "Edit Article") . " | Admin";
require_once __DIR__ . '/../../includes/header.php';
?>

<div class="min-h-full">
    <?php include __DIR__ . '/nav.php'; ?>

    <main class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                <?= $is_new ? "Create New Article" : "Edit Article" ?>
            </h1>
            <a href="/admin/knowledgebase.php" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Back to Articles
            </a>
        </div>

        <?php if(!empty($errors)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <?php foreach($errors as $error): ?>
                    <p class="text-red-700"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white shadow rounded-lg">
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($article['title']) ?>" required class="w-full input-field">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category*</label>
                            <select name="category" class="w-full input-field">
                                <option value="selling" <?= $article['category'] === 'selling' ? 'selected' : '' ?>Selling Your Car</option>
                                <option value="buying" <?= $article['category'] === 'buying' ? 'selected' : '' ?>Buyer Guides</option>
                                <option value="general" <?= $article['category'] === 'general' ? 'selected' : '' ?>General Information</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status*</label>
                            <select name="status" class="w-full input-field">
                                <option value="draft" <?= $article['status'] === 'draft' ? 'selected' : '' ?>Draft</option>
                                <option value="published" <?= $article['status'] === 'published' ? 'selected' : '' ?>Published</option>
                                <option value="archived" <?= $article['status'] === 'archived' ? 'selected' : '' ?>Archived</option>
                            </select>
                        </div>
                    </div>

                    <?php if(!$is_new): ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Change Reason*</label>
                            <input type="text" name="change_reason" placeholder="Briefly describe what you changed" required class="w-full input-field">
                            <p class="text-xs text-gray-500 mt-1">This will be recorded in the version history</p>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Content*</label>
                        <textarea name="content" id="editor" rows="15" class="w-full input-field"><?= htmlspecialchars($article['content']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="px-6 py-3 bg-gray-50 text-right">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i> <?= $is_new ? 'Create Article' : 'Save Changes' ?>
                </button>
            </div>
        </form>
    </main>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>