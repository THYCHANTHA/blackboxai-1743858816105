<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Create car_brands table
$conn->query("
CREATE TABLE IF NOT EXISTS car_brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    logo_path VARCHAR(255) NOT NULL,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Add brand_id column to cars table
$conn->query("ALTER TABLE cars ADD COLUMN brand_id INT AFTER user_id");
$conn->query("ALTER TABLE cars ADD FOREIGN KEY (brand_id) REFERENCES car_brands(id)");

echo "Successfully added brands table and relationships\n";
?>