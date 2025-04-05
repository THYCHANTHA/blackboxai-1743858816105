-- Complete Database Schema with Version History Support

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Enhanced Cars Table
CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    price_usd DECIMAL(10,2) NOT NULL,
    price_khr DECIMAL(12,2) NOT NULL,
    mileage INT NOT NULL,
    color VARCHAR(30),
    vin VARCHAR(17),
    description TEXT,
    car_type ENUM('sedan','suv','truck','hatchback','coupe','convertible','van','electric','hybrid','luxury') NOT NULL,
    status ENUM('pending','approved','sold') DEFAULT 'pending',
    view_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Car Images Table
CREATE TABLE car_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

-- Car Reactions Table
CREATE TABLE car_reactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    user_id INT NOT NULL,
    reaction_type ENUM('like','love','interested') DEFAULT 'like',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY (car_id, user_id)
);

-- Car View Tracking
CREATE TABLE car_views (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    user_id INT NULL,
    ip_address VARCHAR(45) NOT NULL,
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Car Version History
CREATE TABLE car_versions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    version INT NOT NULL,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    mileage INT NOT NULL,
    color VARCHAR(30),
    vin VARCHAR(17),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    changed_by INT NOT NULL,
    change_reason VARCHAR(255),
    FOREIGN KEY (car_id) REFERENCES cars(id),
    FOREIGN KEY (changed_by) REFERENCES users(id),
    UNIQUE KEY (car_id, version)
);

-- Knowledge Base Articles
CREATE TABLE knowledgebase (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    status ENUM('draft','published','archived') DEFAULT 'draft',
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    current_version INT DEFAULT 1,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Knowledge Base Version History
CREATE TABLE knowledgebase_versions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    version INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    changed_by INT NOT NULL,
    change_reason VARCHAR(255),
    FOREIGN KEY (article_id) REFERENCES knowledgebase(id),
    FOREIGN KEY (changed_by) REFERENCES users(id),
    UNIQUE KEY (article_id, version)
);

-- Indexes for better performance
CREATE INDEX idx_cars_user ON cars(user_id);
CREATE INDEX idx_car_versions_car ON car_versions(car_id);
CREATE INDEX idx_knowledgebase_category ON knowledgebase(category);