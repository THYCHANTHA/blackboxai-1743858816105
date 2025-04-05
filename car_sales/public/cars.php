<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

// Set page title
$page_title = "Car Inventory | " . SITE_NAME;

// Sample makes and models (in a real app, these would come from database)
$makes = ['Porsche', 'Mercedes-Benz', 'BMW', 'Audi', 'Tesla', 'Jaguar'];
$models = [
    'Porsche' => ['911', 'Taycan', 'Cayenne', 'Panamera'],
    'Mercedes-Benz' => ['S-Class', 'E-Class', 'GLE', 'GLS'],
    'BMW' => ['7 Series', '5 Series', 'X5', 'X7'],
    'Audi' => ['A8', 'Q8', 'e-tron', 'RS6'],
    'Tesla' => ['Model S', 'Model X', 'Model 3', 'Model Y'],
    'Jaguar' => ['F-PACE', 'XF', 'XJ', 'I-PACE']
];

// Sample cars data (in a real app, this would come from database)
$cars = [
    [
        'id' => 1,
        'make' => 'Porsche',
        'model' => '911 Turbo S',
        'year' => 2023,
        'price' => 203500,
        'mileage' => 1200,
        'color' => 'GT Silver Metallic',
        'image' => 'https://images.pexels.com/photos/120049/pexels-photo-120049.jpeg'
    ],
    [
        'id' => 2,
        'make' => 'Mercedes-Benz',
        'model' => 'S-Class',
        'year' => 2023,
        'price' => 114000,
        'mileage' => 3500,
        'color' => 'Obsidian Black',
        'image' => 'https://images.pexels.com/photos/112460/pexels-photo-112460.jpeg'
    ],
    [
        'id' => 3,
        'make' => 'BMW',
        'model' => 'M8 Competition',
        'year' => 2023,
        'price' => 133000,
        'mileage' => 2800,
        'color' => 'Tanzanite Blue',
        'image' => 'https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg'
    ],
    [
        'id' => 4,
        'make' => 'Audi',
        'model' => 'RS6 Avant',
        'year' => 2023,
        'price' => 125000,
        'mileage' => 4200,
        'color' => 'Nardo Gray',
        'image' => 'https://images.pexels.com/photos/1149831/pexels-photo-1149831.jpeg'
    ],
    [
        'id' => 5,
        'make' => 'Tesla',
        'model' => 'Model S Plaid',
        'year' => 2023,
        'price' => 135000,
        'mileage' => 1500,
        'color' => 'Pearl White',
        'image' => 'https://images.pexels.com/photos/358070/pexels-photo-358070.jpeg'
    ],
    [
        'id' => 6,
        'make' => 'Jaguar',
        'model' => 'F-PACE SVR',
        'year' => 2023,
        'price' => 98000,
        'mileage' => 3800,
        'color' => 'British Racing Green',
        'image' => 'https://images.pexels.com/photos/116675/pexels-photo-116675.jpeg'
    ]
];
?>

<!-- Filter Section -->
<section class="py-8 bg-gray-50 sticky top-16 z-40 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="w-full md:w-auto">
                <label for="make" class="block text-sm font-medium text-gray-700 mb-1">Make</label>
                <select id="make" class="w-full md:w-48 px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Makes</option>
                    <?php foreach($makes as $make): ?>
                        <option value="<?php echo $make; ?>"><?php echo $make; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="w-full md:w-auto">
                <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                <select id="model" class="w-full md:w-48 px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500" disabled>
                    <option value="">All Models</option>
                </select>
            </div>
            
            <div class="w-full md:w-auto">
                <label for="price-range" class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                <div class="flex items-center gap-2">
                    <input type="number" id="min-price" placeholder="Min" class="w-20 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <span>to</span>
                    <input type="number" id="max-price" placeholder="Max" class="w-20 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="w-full md:w-auto">
                <label for="year-range" class="block text-sm font-medium text-gray-700 mb-1">Year Range</label>
                <div class="flex items-center gap-2">
                    <input type="number" id="min-year" placeholder="Min" class="w-20 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <span>to</span>
                    <input type="number" id="max-year" placeholder="Max" class="w-20 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <button id="apply-filters" class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-300">
                Apply Filters
            </button>
        </div>
    </div>
</section>

<!-- Inventory Grid Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Available Inventory</h2>
            <div class="mt-4 md:mt-0">
                <label for="sort" class="mr-2 text-sm font-medium text-gray-700">Sort by:</label>
                <select id="sort" class="px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="year_desc">Year: Newest First</option>
                    <option value="year_asc">Year: Oldest First</option>
                    <option value="mileage_asc">Mileage: Low to High</option>
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="inventory-grid">
            <?php foreach($cars as $car): 
                $formatted_price = number_format($car['price'], 0);
                $formatted_mileage = number_format($car['mileage'], 0);
            ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-[1.02]" data-make="<?php echo $car['make']; ?>" data-model="<?php echo $car['model']; ?>" data-price="<?php echo $car['price']; ?>" data-year="<?php echo $car['year']; ?>">
                    <div class="relative h-48 overflow-hidden">
                        <img src="<?php echo $car['image']; ?>" alt="<?php echo $car['make'] . ' ' . $car['model']; ?>" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                            New Arrival
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold"><?php echo $car['year'] . ' ' . $car['make'] . ' ' . $car['model']; ?></h3>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-blue-500 font-bold">$<?php echo $formatted_price; ?></span>
                            <span class="text-gray-600 text-sm"><?php echo $formatted_mileage; ?> miles</span>
                        </div>
                        <div class="mt-4 flex justify-between text-sm text-gray-500">
                            <span><i class="fas fa-tachometer-alt mr-1"></i> <?php echo $car['color']; ?></span>
                            <span><i class="fas fa-car mr-1"></i> <?php echo $car['year']; ?></span>
                        </div>
                        <a href="car-details.php?id=<?php echo $car['id']; ?>" class="mt-6 inline-block w-full bg-blue-500 hover:bg-blue-600 text-white text-center px-6 py-2 rounded-lg transition duration-300">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center space-x-2">
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">&amp;laquo;</a>
                <a href="#" class="px-3 py-1 rounded border border-blue-500 bg-blue-500 text-white">1</a>
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">2</a>
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">3</a>
                <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-500 hover:bg-gray-50">&amp;raquo;</a>
            </nav>
        </div>
    </div>
</section>

<!-- Filtering Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Model dropdown population based on make selection
    const makeSelect = document.getElementById('make');
    const modelSelect = document.getElementById('model');
    const modelsData = <?php echo json_encode($models); ?>;
    
    makeSelect.addEventListener('change', function() {
        const selectedMake = this.value;
        modelSelect.innerHTML = '<option value="">All Models</option>';
        
        if (selectedMake && modelsData[selectedMake]) {
            modelSelect.disabled = false;
            modelsData[selectedMake].forEach(function(model) {
                const option = document.createElement('option');
                option.value = model;
                option.textContent = model;
                modelSelect.appendChild(option);
            });
        } else {
            modelSelect.disabled = true;
        }
    });
    
    // Filter application
    document.getElementById('apply-filters').addEventListener('click', function() {
        const selectedMake = makeSelect.value;
        const selectedModel = modelSelect.value;
        const minPrice = document.getElementById('min-price').value || 0;
        const maxPrice = document.getElementById('max-price').value || Infinity;
        const minYear = document.getElementById('min-year').value || 0;
        const maxYear = document.getElementById('max-year').value || Infinity;
        
        document.querySelectorAll('#inventory-grid > div').forEach(function(car) {
            const carMake = car.dataset.make;
            const carModel = car.dataset.model;
            const carPrice = parseFloat(car.dataset.price);
            const carYear = parseFloat(car.dataset.year);
            
            const makeMatch = !selectedMake || carMake === selectedMake;
            const modelMatch = !selectedModel || carModel === selectedModel;
            const priceMatch = carPrice >= minPrice && carPrice <= maxPrice;
            const yearMatch = carYear >= minYear && carYear <= maxYear;
            
            if (makeMatch && modelMatch && priceMatch && yearMatch) {
                car.style.display = 'block';
            } else {
                car.style.display = 'none';
            }
        });
    });
    
    // Sorting functionality
    document.getElementById('sort').addEventListener('change', function() {
        const sortValue = this.value;
        const container = document.getElementById('inventory-grid');
        const cars = Array.from(container.children);
        
        cars.sort(function(a, b) {
            const aPrice = parseFloat(a.dataset.price);
            const bPrice = parseFloat(b.dataset.price);
            const aYear = parseFloat(a.dataset.year);
            const bYear = parseFloat(b.dataset.year);
            
            switch(sortValue) {
                case 'price_asc': return aPrice - bPrice;
                case 'price_desc': return bPrice - aPrice;
                case 'year_desc': return bYear - aYear;
                case 'year_asc': return aYear - bYear;
                default: return 0;
            }
        });
        
        // Re-append sorted cars
        cars.forEach(function(car) {
            container.appendChild(car);
        });
    });
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>