<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

// Set page title
$page_title = "Contact Us | " . SITE_NAME;

// Business hours data
$business_hours = [
    ['day' => 'Monday - Friday', 'hours' => '9:00 AM - 7:00 PM'],
    ['day' => 'Saturday', 'hours' => '10:00 AM - 6:00 PM'],
    ['day' => 'Sunday', 'hours' => 'Closed']
];
?>

<!-- Hero Section -->
<section class="relative h-96 flex items-center justify-center text-center text-white bg-gray-900">
    <div class="absolute inset-0">
        <img src="https://images.pexels.com/photos/380769/pexels-photo-380769.jpeg" alt="Car Dealership" class="w-full h-full object-cover opacity-50">
    </div>
    <div class="relative z-10 px-4">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Contact Elite Motors</h1>
        <p class="text-xl md:text-2xl max-w-2xl mx-auto">Our team is ready to assist you with all your automotive needs</p>
    </div>
</section>

<!-- Contact Grid -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold mb-6">Send Us a Message</h2>
                <form id="contact-form" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" id="first-name" name="first-name" required class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" id="last-name" name="last-name" required class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select id="subject" name="subject" class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="test-drive">Schedule Test Drive</option>
                            <option value="service">Service Appointment</option>
                            <option value="finance">Financing Questions</option>
                            <option value="trade-in">Trade-In Evaluation</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="newsletter" name="newsletter" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="newsletter" class="ml-2 block text-sm text-gray-700">Subscribe to our newsletter</label>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-4 px-6 rounded-lg font-medium text-lg transition duration-300">
                        Send Message
                    </button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h2 class="text-3xl font-bold mb-6">Visit Our Dealership</h2>
                
                <!-- Google Maps Embed -->
                <div class="h-64 md:h-80 mb-8 rounded-lg overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.2152091795357!2d-73.9878449242396!3d40.74844097138989!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1681234567890!5m2!1sen!2sus" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                
                <!-- Address -->
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-blue-500 text-xl mt-1"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Address</h3>
                        <p class="text-gray-600">123 Auto Boulevard<br>Motor City, NY 10001</p>
                    </div>
                </div>
                
                <!-- Phone -->
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0">
                        <i class="fas fa-phone-alt text-blue-500 text-xl mt-1"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Phone</h3>
                        <p class="text-gray-600"><a href="tel:+15551234567" class="hover:text-blue-500">(555) 123-4567</a></p>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0">
                        <i class="fas fa-envelope text-blue-500 text-xl mt-1"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Email</h3>
                        <p class="text-gray-600"><a href="mailto:info@elitemotors.com" class="hover:text-blue-500">info@elitemotors.com</a></p>
                    </div>
                </div>
                
                <!-- Business Hours -->
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clock text-blue-500 text-xl mt-1"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold mb-2">Business Hours</h3>
                        <ul class="space-y-2">
                            <?php foreach($business_hours as $hours): ?>
                                <li class="flex justify-between">
                                    <span class="text-gray-600"><?php echo $hours['day']; ?></span>
                                    <span class="font-medium"><?php echo $hours['hours']; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Script -->
<script>
document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Form validation
    const firstName = document.getElementById('first-name').value.trim();
    const lastName = document.getElementById('last-name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();
    
    if (!firstName || !lastName || !email || !message) {
        alert('Please fill in all required fields');
        return;
    }
    
    // In a real app, you would send the form data to the server here
    alert('Thank you for your message! We will contact you soon.');
    this.reset();
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>