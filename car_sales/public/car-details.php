<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

// In a real app, this would come from database based on ID parameter
$car = [
    'id' => 1,
    'make' => 'Porsche',
    'model' => '911 Turbo S',
    'year' => 2023,
    'price' => 203500,
    'mileage' => 1200,
    'color' => 'GT Silver Metallic',
    'engine' => '3.8L Twin-Turbo Flat-6',
    'transmission' => '8-Speed PDK',
    'drivetrain' => 'AWD',
    'fuel_type' => 'Premium',
    'mpg_city' => 18,
    'mpg_highway' => 24,
    'vin' => 'WP0AB2A99PS123456',
    'description' => 'The Porsche 911 Turbo S combines breathtaking performance with everyday usability. This example features the full leather interior, Burmester sound system, and carbon ceramic brakes.',
    'features' => [
        'Premium Package',
        'Sport Chrono Package',
        'Ventilated Seats',
        'Heated Steering Wheel',
        'Apple CarPlay',
        'Parking Sensors',
        '360 Camera'
    ],
    'images' => [
        'https://images.pexels.com/photos/120049/pexels-photo-120049.jpeg',
        'https://images.pexels.com/photos/919073/pexels-photo-919073.jpeg',
        'https://images.pexels.com/photos/1545743/pexels-photo-1545743.jpeg',
        'https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg'
    ]
];

$formatted_price = number_format($car['price'], 0);
$formatted_mileage = number_format($car['mileage'], 0);

// Set page title
$page_title = $car['year'] . ' ' . $car['make'] . ' ' . $car['model'] . ' | ' . SITE_NAME;
?>

<!-- Main Content -->
<main class="py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo SITE_URL; ?>/index.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <a href="<?php echo SITE_URL; ?>/cars.php" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Inventory</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2"><?php echo $car['year'] . ' ' . $car['make'] . ' ' . $car['model']; ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Car Title and Price -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold"><?php echo $car['year'] . ' ' . $car['make'] . ' ' . $car['model']; ?></h1>
            <div class="mt-4 md:mt-0">
                <span class="text-3xl font-bold text-blue-500">$<?php echo $formatted_price; ?></span>
            </div>
        </div>

        <!-- Image Gallery -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Main Image -->
            <div class="relative h-96 rounded-lg overflow-hidden">
                <img id="main-image" src="<?php echo $car['images'][0]; ?>" alt="<?php echo $car['make'] . ' ' . $car['model']; ?>" class="w-full h-full object-cover">
                <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                    Just Arrived
                </div>
            </div>

            <!-- Thumbnails -->
            <div class="grid grid-cols-4 gap-2">
                <?php foreach($car['images'] as $index => $image): ?>
                    <div class="cursor-pointer" onclick="document.getElementById('main-image').src = '<?php echo $image; ?>'">
                        <img src="<?php echo $image; ?>" alt="<?php echo $car['make'] . ' ' . $car['model'] . ' - Image ' . ($index + 1); ?>" class="w-full h-20 object-cover rounded">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Specifications -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold mb-6">Vehicle Specifications</h2>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Overview</h3>
                            <ul class="space-y-3">
                                <li class="flex justify-between">
                                    <span class="text-gray-600">Make</span>
                                    <span class="font-medium"><?php echo $car['make']; ?></span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">Model</span>
                                    <span class="font-medium"><?php echo $car['model']; ?></span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">Year</span>
                                    <span class="font-medium"><?php echo $car['year']; ?></span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">Mileage</span>
                                    <span class="font-medium"><?php echo $formatted_mileage; ?> miles</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">Color</span>
                                    <span class="font-medium"><?php echo $car['color']; ?></span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">VIN</span>
                                    <span class="font-medium"><?php echo $car['vin']; ?></span>
                                </li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Mechanical</h3>
                            <ul class="space-y-3">
                                <li class="flex justify-between">
                                    <span class="text-gray-600">Engine</span>
                                    <span class="font-medium"><?php echo $car['engine']; ?></span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">Transmission</span>
                                    <span class="font-medium"><?php echo $car['transmission']; ?></span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">Drivetrain</span>
                                    <span class="font-medium"><?php echo $car['drivetrain']; ?></span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">Fuel Type</span>
                                    <span class="font-medium"><?php echo $car['fuel_type']; ?></span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">MPG (City)</span>
                                    <span class="font-medium"><?php echo $car['mpg_city']; ?></span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-600">MPG (Highway)</span>
                                    <span class="font-medium"><?php echo $car['mpg_highway']; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Features -->
                <h3 class="text-lg font-semibold mt-8 mb-4">Features &amp; Options</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <?php foreach($car['features'] as $feature): ?>
                        <div class="flex items-center bg-gray-50 px-4 py-2 rounded">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span><?php echo $feature; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Description -->
                <h3 class="text-lg font-semibold mt-8 mb-4">Description</h3>
                <p class="text-gray-700"><?php echo $car['description']; ?></p>
            </div>
            
            <!-- Contact Form -->
            <div class="bg-white shadow-lg rounded-lg p-6 h-fit sticky top-4">
                <h2 class="text-xl font-bold mb-6">Contact Seller</h2>
                <form id="contact-form" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">I'm interested in the <?php echo $car['year'] . ' ' . $car['make'] . ' ' . $car['model']; ?> (VIN: <?php echo $car['vin']; ?>)</textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300">
                        Send Inquiry
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500">Or call us directly at</p>
                    <a href="tel:+15551234567" class="text-blue-500 font-medium">(555) 123-4567</a>
                </div>
            </div>
        </div>
        
        <!-- Similar Vehicles -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Similar Vehicles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Sample similar cars (in a real app, these would come from database) -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative h-48">
                        <img src="https://images.pexels.com/photos/112460/pexels-photo-112460.jpeg" alt="Mercedes-Benz S-Class" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold">2023 Mercedes-Benz S-Class</h3>
                        <p class="text-blue-500 font-bold">$114,000</p>
                        <a href="car-details.php?id=2" class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">View Details</a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative h-48">
                        <img src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg" alt="BMW M8 Competition" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold">2023 BMW M8 Competition</h3>
                        <p class="text-blue-500 font-bold">$133,000</p>
                        <a href="car-details.php?id=3" class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">View Details</a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                    <div class="relative h-48">
                        <img src="https://images.pexels.com/photos/1149831/pexels-photo-1149831.jpeg" alt="Audi RS6 Avant" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold">2023 Audi RS6 Avant</h3>
                        <p class="text-blue-500 font-bold">$125,000</p>
                        <a href="car-details.php?id=4" class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">View Details</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>