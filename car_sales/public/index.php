<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

// Set page title
$page_title = "Premium Luxury Cars | " . SITE_NAME;
?>

<!-- Hero Section (Tesla-style fullscreen video background) -->
<section class="relative h-screen flex items-center justify-center text-center text-white overflow-hidden">
    <div class="absolute inset-0">
        <video autoplay loop muted playsinline class="w-full h-full object-cover">
            <source src="https://player.vimeo.com/external/123456789.hd.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>
    
    <div class="relative z-10 px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">Redefine Your Drive</h1>
        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">Discover our curated collection of premium vehicles</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="cars.php" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-medium transition duration-300">
                Browse Inventory
            </a>
            <a href="contact.php" class="bg-transparent hover:bg-white hover:text-black border-2 border-white text-white px-8 py-3 rounded-full text-lg font-medium transition duration-300">
                Book Test Drive
            </a>
        </div>
    </div>
</section>

<!-- Featured Vehicles Section -->
<section class="py-16 bg-gray-50" id="inventory">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Featured Vehicles</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            // Sample featured cars (in a real app, this would come from database)
            $featured_cars = [
                [
                    'make' => 'Porsche',
                    'model' => '911 Turbo S',
                    'year' => 2023,
                    'price' => 203500,
                    'image' => 'https://images.pexels.com/photos/120049/pexels-photo-120049.jpeg'
                ],
                [
                    'make' => 'Mercedes-Benz',
                    'model' => 'S-Class',
                    'year' => 2023,
                    'price' => 114000,
                    'image' => 'https://images.pexels.com/photos/112460/pexels-photo-112460.jpeg'
                ],
                [
                    'make' => 'BMW',
                    'model' => 'M8 Competition',
                    'year' => 2023,
                    'price' => 133000,
                    'image' => 'https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg'
                ]
            ];

            foreach ($featured_cars as $car): 
                $formatted_price = number_format($car['price'], 0);
            ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105">
                    <div class="relative h-48 overflow-hidden">
                        <img src="<?php echo $car['image']; ?>" alt="<?php echo $car['make'] . ' ' . $car['model']; ?>" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                            Featured
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold"><?php echo $car['year'] . ' ' . $car['make'] . ' ' . $car['model']; ?></h3>
                        <p class="text-gray-600 mb-4">Starting at <span class="text-blue-500 font-bold">$<?php echo $formatted_price; ?></span></p>
                        <a href="car-details.php" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full transition duration-300">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="cars.php" class="inline-block bg-black hover:bg-gray-800 text-white px-8 py-3 rounded-full text-lg font-medium transition duration-300">
                View All Inventory
            </a>
        </div>
    </div>
</section>

<!-- Key Features Section -->
<section class="py-16 bg-white" id="features">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Why Choose Elite Motors</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-blue-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Certified Pre-Owned</h3>
                <p class="text-gray-600">Rigorous 200-point inspection process for quality assurance</p>
            </div>
            
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-usd text-blue-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Competitive Pricing</h3>
                <p class="text-gray-600">Best market prices with price match guarantee</p>
            </div>
            
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-blue-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Premium Service</h3>
                <p class="text-gray-600">White-glove concierge service for all clients</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 bg-gray-50" id="testimonials">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Client Testimonials</h2>
        
        <div class="max-w-4xl mx-auto">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <div class="flex items-center mb-6">
                    <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg" alt="Client" class="w-16 h-16 rounded-full object-cover">
                    <div class="ml-4">
                        <h4 class="font-bold">Michael Johnson</h4>
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic">"The team at Elite Motors made my car buying experience exceptional. Their attention to detail and transparent process gave me complete confidence in my purchase."</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 bg-blue-500 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-6">Ready to Find Your Dream Car?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">Schedule a consultation with our specialists today</p>
        <a href="contact.php" class="inline-block bg-white hover:bg-gray-100 text-blue-500 px-8 py-3 rounded-full text-lg font-medium transition duration-300">
            Contact Us
        </a>
    </div>
</section>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>