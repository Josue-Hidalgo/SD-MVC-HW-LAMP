-- This file contains stored procedures for analyzing access logs in the database.
-- These procedures were done with based on the queries in Consults.sql, but now they are encapsulated in procedures for easier reuse and better organization.

-- TEST PROCEDURES

DELIMITER $$

CREATE PROCEDURE GetTotalAccesses()
BEGIN
    SELECT COUNT(*) AS total_accesses
    FROM AccessLog;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE DeleteAllData()
BEGIN
    DELETE FROM AccessLog;
    DELETE FROM ShortCut;
END$$

DELIMITER ;

-- INSETERS 

DELIMITER $$

CREATE PROCEDURE InsertShortCut(IN p_short_code VARCHAR(10), IN p_original_url VARCHAR(2048), IN p_base_url VARCHAR(255))
BEGIN
    INSERT INTO ShortCut (short_code, original_url, base_url)
    VALUES (p_short_code, p_original_url, p_base_url);
END$$

DELIMITER ;

-- GETTERS

DELIMITER $$

CREATE PROCEDURE InsertAccessLogByCode(
    IN p_short_code VARCHAR(10),
    IN p_ip_address VARCHAR(45),
    IN p_country VARCHAR(10)
)
BEGIN
    DECLARE v_id INT;

    SELECT id_short_cut INTO v_id
    FROM ShortCut
    WHERE short_code = p_short_code;

    IF v_id IS NOT NULL THEN
        INSERT INTO AccessLog (id_short_cut, ip_address, country)
        VALUES (v_id, p_ip_address, p_country);
    END IF;
END$$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE GetTotalAccessesByShortcut(IN p_id_shortcut INT)
BEGIN
    SELECT COUNT(*) AS total_access
    FROM AccessLog
    WHERE id_short_cut = p_id_shortcut;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetAccessesByDay(IN p_id_shortcut INT)
BEGIN
    SELECT DATE(access_date) AS day, COUNT(*) AS total
    FROM AccessLog
    WHERE id_short_cut = p_id_shortcut
    GROUP BY day
    ORDER BY day;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetAccessesByCountry(IN p_id_shortcut INT)
BEGIN
    SELECT country, COUNT(*) AS total
    FROM AccessLog
    WHERE id_short_cut = p_id_shortcut
    GROUP BY country;
END$$

DELIMITER ;

-- HOW TO CALL THEM!!!

-- Insertar un nuevo shortcut
CALL InsertShortCut('abc123', 'https://www.google.com', 'https://tuapp.com/');
-- Registrar un acceso usando el short_code
CALL InsertAccessLogByCode('abc123', '192.168.1.1', 'CR');
-- Obtener total de accesos
CALL GetTotalAccesses();
-- Obtener total de accesos por shortcut (usando ID)
CALL GetTotalAccessesByShortcut(1);
-- Obtener accesos por día
CALL GetAccessesByDay(1);
-- Obtener accesos por país
CALL GetAccessesByCountry(1);
-- Eliminar todos los datos (cuidado)
CALL DeleteAllData();