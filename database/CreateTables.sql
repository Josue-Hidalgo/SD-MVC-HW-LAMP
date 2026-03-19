CREATE TABLE ShortCut (
    id_short_cut INT AUTO_INCREMENT PRIMARY KEY,
    short_code VARCHAR(10) NOT NULL UNIQUE,
    original_url VARCHAR(2048) NOT NULL,
    base_url VARCHAR(255) NOT NULL,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE AccessLog (
    id_access_log BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_short_cut INT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    country VARCHAR(45) NOT NULL,
    access_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_short_cut) REFERENCES ShortCut(id_short_cut)
);