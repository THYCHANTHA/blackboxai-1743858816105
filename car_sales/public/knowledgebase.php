<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = "Knowledge Base | " . SITE_NAME;
require_once __DIR__ . '/../includes/header.php';

// Categories and articles (would come from DB in production)
$categories = [
    'Selling Your Car' => [
        'How to create effective listings',
        'Pricing your vehicle',
        'Taking great photos'
    ],
    'Buyer Guides' => [
        'Inspection checklist',
        'Financing options',
        'Negotiation tips'
    ]
];
?>

<div class="container mx-auto py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-bold mb-4">Categories</h3>
                <nav class="space-y-2">
                    <?php foreach(array_keys($categories) as $category): ?>
                        <a href="#<?= slugify($category) ?>" class="block hover:text-blue-600">
                            <?= htmlspecialchars($category) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
                
                <div class="mt-6">
                    <h3 class="font-bold mb-2">Search Articles</h3>
                    <form class="flex">
                        <input type="text" placeholder="Search..." class="flex-grow border rounded-l px-3 py-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 rounded-r">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            <h1 class="text-3xl font-bold mb-6">Knowledge Base</h1>
            
            <?php foreach($categories as $category => $articles): ?>
                <section id="<?= slugify($category) ?>" class="mb-8">
                    <h2 class="text-2xl font-semibold mb-4 pb-2 border-b">
                        <?= htmlspecialchars($category) ?>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach($articles as $article): ?>
                            <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition-shadow">
                                <h3 class="font-bold text-lg mb-2">
                                    <?= htmlspecialchars($article) ?>
                                </h3>
                                <p class="text-gray-600 text-sm mb-3">
                                    Brief description of what this article covers...
                                </p>
                                <a href="#" class="text-blue-600 text-sm font-medium">Read more →</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
            
            <div class="bg-white shadow rounded-lg p-6 mt-6">
                <h2 class="text-xl font-semibold mb-4">Contribute to our Knowledge Base</h2>
                <p class="mb-4">Have suggestions for improving our documentation?</p>
                <a href="contact.php?subject=Knowledge%20Base%20Suggestion" class="btn-primary">
                    Submit Your Suggestions
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>