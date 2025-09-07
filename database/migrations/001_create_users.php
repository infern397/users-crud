<?php
return <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    birth_year INT NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    photo VARCHAR(255),
    is_admin BOOLEAN DEFAULT FALSE,
    created_by INT NULL
);
SQL;