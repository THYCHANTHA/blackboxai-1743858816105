<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

// Redirect if already logged in
if(isset($_SESSION['user_id'])) {
    header('Location: ' . SITE_URL);
    exit;
}

// Set page title
$page_title = "Login | " . SITE_NAME;
?>

<!-- Login Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-blue-500 py-4 px-6">
                <h2 class="text-2xl font-bold text-white">Login to Your Account</h2>
            </div>
            
            <div class="p-6">
                <form id="login-form" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <div class="flex justify-end mt-1">
                            <a href="forgot-password.php" class="text-sm text-blue-500 hover:underline">Forgot password?</a>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300">
                        Login
                    </button>
                </form>
                
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fab fa-google text-red-500 mr-2"></i> Google
                        </a>
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fab fa-facebook-f text-blue-600 mr-2"></i> Facebook
                        </a>
                    </div>
                </div>
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="register.php" class="font-medium text-blue-500 hover:underline">Register here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Login Script -->
<script>
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    
    if(!email || !password) {
        alert('Please fill in all fields');
        return;
    }
    
    // In a real app, you would send this to the server for authentication
    // This is just a demo implementation
    if(email === 'demo@elitemotors.com' && password === 'demo123') {
        alert('Login successful! Redirecting...');
        window.location.href = '<?php echo SITE_URL; ?>';
    } else {
        alert('Invalid email or password');
    }
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>