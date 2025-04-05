<?php
// Brand Slider Component
function displayBrandSlider($conn) {
    $featured_brands = $conn->query("
        SELECT * FROM car_brands 
        WHERE is_featured = TRUE 
        ORDER BY name
    ")->fetch_all(MYSQLI_ASSOC);
    ?>
    <div class="mb-12 px-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Browse By Brand</h2>
        <div class="flex overflow-x-auto gap-8 py-2">
            <?php foreach($featured_brands as $brand): ?>
                <a href="cars.php?brand=<?= urlencode($brand['name']) ?>" class="flex flex-col items-center min-w-[120px]">
                    <img src="<?= $brand['logo_path'] ?>" alt="<?= $brand['name'] ?>" class="h-16">
                    <p class="mt-2 font-medium"><?= $brand['name'] ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
?>