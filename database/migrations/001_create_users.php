<?php
return <<<SQL
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    birth_year INT NOT NULL,
    gender ENUM('male','female') NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
SQL;