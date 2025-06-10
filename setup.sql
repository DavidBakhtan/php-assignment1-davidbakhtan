-- Create database and tables
CREATE DATABASE IF NOT EXISTS assignment1;
USE assignment1;

CREATE TABLE IF NOT EXISTS categories (
    categoryID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    productID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    categoryID INT NOT NULL,
    FOREIGN KEY (categoryID) REFERENCES categories(categoryID)
);

-- Sample data
INSERT INTO categories (name) VALUES
('Fishing'),('Running'),('Soccer'),('Basketball');
INSERT INTO products (name, price, categoryID) VALUES
('Product A', 10.00, 1),
('Product B', 20.00, 2),
('Product C', 30.00, 3);