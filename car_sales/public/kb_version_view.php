<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Validate parameters
if(!isset($_GET['article_id']) || !is_numeric($_GET['article_id']) || 
   !isset($_GET['version']) || !is_numeric($_GET['version'])) {
    header('Location: knowledgebase.php');
    exit;
}

$article_id = (int)$_GET['article_id'];
$version = (int)$_GET['version'];

// Get current article details
$current_article = [];
$stmt = $conn->prepare("SELECT * FROM knowledgebase WHERE id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) {
    header('Location: knowledgebase.php');
    exit;
}
$current_article = $result->fetch_assoc();

// Get version details
$version_data = [];
$stmt = $conn->prepare("SELECT v.*, u.username FROM knowledgebase_versions v JOIN users u ON v.changed_by = u.id WHERE v.article_id = ? AND v.version = ?");
$stmt->bind_param("ii", $article_id, $version);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) {
    header("Location: kb_version_history.php?id=$article_id");
    exit;
}
$version_data = $result->fetch_assoc();

$page_title = "Version v$version | " . htmlspecialchars($version_data['title']);
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">
            Version v<?= $version ?>: <?= htmlspecialchars($version_data['title']) ?>
        </h1>
        <a href="kb_version_history.php?id=<?= $article_id ?>" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to History
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="mb-4">
            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?= $version == $current_article['current_version'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                <?= $version == $current_article['current_version'] ? 'Current Version' : 'Past Version' ?>
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-medium mb-2">Version Details</h3>
                <div class="space-y-2">
                    <p><strong>Modified By:</strong> <?= htmlspecialchars($version_data['username']) ?></p>
                    <p><strong>Modified On:</strong> <?= date('M j, Y g:i a', strtotime($version_data['created_at'])) ?></p>
                    <p><strong>Change Reason:</strong> <?= htmlspecialchars($version_data['change_reason'] ?? 'No reason provided') ?></p>
                    <p><strong>Category:</strong> <?= htmlspecialchars(ucfirst($version_data['category'])) ?></p>
                </div>
            </div>
            
            <div>
                <h3 class="text-lg font-medium mb-2">Actions</h3>
                <div class="space-y-2">
                    <?php if(isAdmin() && $version != $current_article['current_version']): ?>
                        <a href="kb_version_restore.php?article_id=<?= $article_id ?>&amp;version=<?= $version ?>" class="btn-primary inline-block" onclick="return confirm('Restore this version?')">
                            <i class="fas fa-history mr-2"></i> Restore This Version
                        </a>
                    <?php endif; ?>
                    <a href="knowledgebase_article.php?id=<?= $article_id ?>" class="btn-secondary inline-block">
                        <i class="fas fa-file-alt mr-2"></i> View Current Version
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="prose max-w-none">
                <?= $version_data['content'] ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>