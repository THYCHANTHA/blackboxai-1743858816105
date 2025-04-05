<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

// Redirect if already logged in
if(isset($_SESSION['user_id'])) {
    header('Location: ' . SITE_URL);
    exit;
}

// Set page title
$page_title = "Register | " . SITE_NAME;
?>

<!-- Registration Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-blue-500 py-4 px-6">
                <h2 class="text-2xl font-bold text-white">Create Your Account</h2>
            </div>
            
            <div class="p-6">
                <form id="register-form" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" id="first-name" name="first-name" required 
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" id="last-name" name="last-name" required 
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                               class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters long</p>
                    </div>
                    
                    <div>
                        <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" required 
                               class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="terms" name="terms" required 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the <a href="#" class="text-blue-500 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-500 hover:underline">Privacy Policy</a>
                        </label>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300">
                        Create Account
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="login.php" class="font-medium text-blue-500 hover:underline">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Registration Script -->
<script>
document.getElementById('register-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const firstName = document.getElementById('first-name').value.trim();
    const lastName = document.getElementById('last-name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const terms = document.getElementById('terms').checked;
    
    // Basic validation
    if(!firstName || !lastName || !email || !password || !confirmPassword) {
        alert('Please fill in all required fields');
        return;
    }
    
    if(!terms) {
        alert('You must agree to the terms and conditions');
        return;
    }
    
    if(password.length < 8) {
        alert('Password must be at least 8 characters long');
        return;
    }
    
    if(password !== confirmPassword) {
        alert('Passwords do not match');
        return;
    }
    
    // In a real app, you would send this to the server for processing
    alert('Registration successful! Redirecting to login...');
    window.location.href = 'login.php';
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>