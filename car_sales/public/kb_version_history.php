<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Validate article ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: knowledgebase.php');
    exit;
}

$article_id = (int)$_GET['id'];

// Get current article details
$article = [];
$stmt = $conn->prepare("SELECT * FROM knowledgebase WHERE id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows === 0) {
    header('Location: knowledgebase.php');
    exit;
}
$article = $result->fetch_assoc();

// Get version history
$versions = [];
$stmt = $conn->prepare("SELECT v.*, u.username FROM knowledgebase_versions v JOIN users u ON v.changed_by = u.id WHERE v.article_id = ? ORDER BY v.version DESC");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
if($result) {
    $versions = $result->fetch_all(MYSQLI_ASSOC);
}

$page_title = "Version History | " . htmlspecialchars($article['title']);
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">
            Version History: <?= htmlspecialchars($article['title']) ?>
        </h1>
        <a href="knowledgebase_article.php?id=<?= $article_id ?>" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to Article
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Version</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Modified By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Changes</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach($versions as $version): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $version['version'] == $article['current_version'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                v<?= $version['version'] ?> <?= $version['version'] == $article['current_version'] ? '(Current)' : '' ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= htmlspecialchars($version['username']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?= date('M j, Y g:i a', strtotime($version['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= htmlspecialchars($version['change_reason'] ?? 'No change reason provided') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="kb_version_view.php?article_id=<?= $article_id ?>&amp;version=<?= $version['version'] ?>" class="text-blue-600 hover:text-blue-900">View</a>
                            <?php if(isAdmin() && $version['version'] != $article['current_version']): ?>
                                <span class="mx-2 text-gray-300">|</span>
                                <a href="kb_version_restore.php?article_id=<?= $article_id ?>&amp;version=<?= $version['version'] ?>" class="text-blue-600 hover:text-blue-900" onclick="return confirm('Restore this version?')">Restore</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>