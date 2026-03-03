-- Fashion E-commerce Database Schema

CREATE DATABASE IF NOT EXISTS fashion_db;
USE fashion_db;

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    is_featured BOOLEAN DEFAULT FALSE,
    is_new BOOLEAN DEFAULT TRUE,
    is_sale BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Sample Categories
INSERT INTO categories (name, slug, image) VALUES 
('Menswear', 'menswear', 'https://images.unsplash.com/photo-1608739872077-21ddc15dc152?q=80&w=1470&auto=format&fit=crop'),
('Womenswear', 'womenswear', 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop'),
('Accessories', 'accessories', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=2066&auto=format&fit=crop');

-- Insert Sample Products
INSERT INTO products (category_id, name, slug, price, image, stock, is_featured, is_new) VALUES 
(1, 'Classic Heritage Trench', 'classic-heritage-trench', 850.00, 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop', 10, 1, 1),
(3, 'Minimalist Signature Watch', 'minimalist-signature-watch', 320.00, 'https://images.unsplash.com/photo-1543076447-215ad9ba6923?q=80&w=1974&auto=format&fit=crop', 25, 1, 0),
(1, 'Artisan Leather Chelsea Boots', 'artisan-leather-boots', 450.00, 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=2012&auto=format&fit=crop', 15, 1, 0),
(1, 'Premium Linen Button-Down', 'premium-linen-shirt', 120.00, 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=1976&auto=format&fit=crop', 50, 0, 1),
(2, 'Sunshine Summer Maxi', 'sunshine-summer-maxi', 180.00, 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1920&auto=format&fit=crop', 30, 0, 0),
(1, 'Urban Oversized Hoodie', 'urban-oversized-hoodie', 95.00, 'https://images.unsplash.com/photo-1539109132374-348214a3c21e?q=80&w=1974&auto=format&fit=crop', 20, 0, 0);
