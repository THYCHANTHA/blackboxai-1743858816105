-- Create car_brands table
CREATE TABLE IF NOT EXISTS car_brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    logo_path VARCHAR(255) NOT NULL,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add brand_id column to cars table if it doesn't exist
SET @dbname = DATABASE();
SET @tablename = 'cars';
SET @columnname = 'brand_id';
SET @preparedStatement = (SELECT IF(
    (
        SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
        WHERE
            (TABLE_SCHEMA = @dbname)
            AND (TABLE_NAME = @tablename)
            AND (COLUMN_NAME = @columnname)
    ) > 0,
    'SELECT 1',
    CONCAT('ALTER TABLE ', @tablename, ' ADD COLUMN ', @columnname, ' INT AFTER user_id, ADD FOREIGN KEY (', @columnname, ') REFERENCES car_brands(id) ON DELETE CASCADE;')
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Sample data for testing
INSERT INTO car_brands (name, logo_path, is_featured) VALUES
('Toyota', '/uploads/brands/toyota.png', TRUE),
('Honda', '/uploads/brands/honda.png', TRUE),
('BMW', '/uploads/brands/bmw.png', TRUE),
('Mercedes', '/uploads/brands/mercedes.png', TRUE),
('Ford', '/uploads/brands/ford.png', FALSE);