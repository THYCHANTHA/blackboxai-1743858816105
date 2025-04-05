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

-- Cars Table with Version Tracking
CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    mileage INT NOT NULL,
    color VARCHAR(30),
    vin VARCHAR(17),
    description TEXT,
    status ENUM('pending','approved','sold') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    current_version INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id)
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