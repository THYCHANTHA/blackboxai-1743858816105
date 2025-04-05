<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

// Redirect if not admin
if(!isAdmin()) {
    header('Location: login.php');
    exit;
}

// Set page title
$page_title = "Admin Dashboard | " . SITE_NAME;

// Custom admin header
$admin_header = true;
require_once __DIR__ . '/../../includes/header.php';

// Get stats for dashboard
$users_count = 0;
$cars_count = 0;
$inquiries_count = 0;

// In a real app, these would come from database queries
// Example:
// $stmt = $conn->query("SELECT COUNT(*) FROM users");
// $users_count = $stmt->fetch_row()[0];
?>

<div class="min-h-full">
    <!-- Admin Navigation -->
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <span class="text-white font-bold">ELITE MOTORS ADMIN</span>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="index.php" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="users.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Users
                            </a>
                            <a href="cars.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Cars
                            </a>
                            <a href="inquiries.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Inquiries
                            </a>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Profile dropdown -->
                        <div class="ml-3 relative">
                            <div>
                                <button type="button" class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <span class="text-white mr-2"><?php echo $_SESSION['username']; ?></span>
                                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="">
                                </button>
                            </div>
                        </div>
                        <a href="../../includes/logout.php" class="ml-3 text-gray-300 hover:text-white text-sm font-medium">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
                <!-- Users Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Users
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            <?php echo $users_count; ?>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="users.php" class="font-medium text-blue-600 hover:text-blue-500">
                                View all
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cars Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <i class="fas fa-car text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Cars
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            <?php echo $cars_count; ?>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="cars.php" class="font-medium text-blue-600 hover:text-blue-500">
                                View all
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Inquiries Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <i class="fas fa-envelope text-white text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        New Inquiries
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            <?php echo $inquiries_count; ?>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="inquiries.php" class="font-medium text-blue-600 hover:text-blue-500">
                                View all
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Recent Activity
                    </h3>
                </div>
                <div class="bg-white overflow-hidden">
                    <ul class="divide-y divide-gray-200">
                        <!-- Sample activity items -->
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-user-plus text-green-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            New user registered
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            2 hours ago
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-car text-blue-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            New car added to inventory
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            5 hours ago
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-envelope text-yellow-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">
                                            New inquiry received
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            1 day ago
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>