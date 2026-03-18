
-- SQL script to create tables for URL shortening service
-- Based on the schema design that you can see in /Docs/Diagram.png

CREATE TABLE ShortCut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    short_code VARCHAR(10) NOT NULL UNIQUE,
    original_url VARCHAR(2048) NOT NULL,
    base_url VARCHAR(255) NOT NULL,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE AccessLog (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    shortcut_id INT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    country VARCHAR(10) NOT NULL,
    access_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (shortcut_id) REFERENCES ShortCut(id)
);