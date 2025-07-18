CREATE DATABASE IF NOT EXISTS chefmate;
USE chefmate;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS saved_recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    recipe_name VARCHAR(100),
    ingredients TEXT
);

-- Sample recipes preloaded
