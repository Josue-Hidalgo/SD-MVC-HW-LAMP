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

-- INSERT PROCEDURES

DELIMITER $$

CREATE PROCEDURE InsertShortCut(
    IN p_short_code VARCHAR(10),
    IN p_original_url VARCHAR(2048),
    IN p_base_url VARCHAR(255)
)
BEGIN
    INSERT INTO ShortCut (short_code, original_url, base_url)
    VALUES (p_short_code, p_original_url, p_base_url);
END$$

DELIMITER ;

-- ACCESS LOG INSERTION

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

-- GETTERS / ANALYTICS

DELIMITER $$

CREATE PROCEDURE GetAccessCountForAllShortCuts()
BEGIN
    SELECT s.id_short_cut,
           s.short_code,
           COUNT(a.id_access_log) AS total_accesses
    FROM ShortCut s
    LEFT JOIN AccessLog a ON s.id_short_cut = a.id_short_cut
    GROUP BY s.id_short_cut
    ORDER BY total_accesses DESC;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetAllShortCuts()
BEGIN
    SELECT id_short_cut, short_code, original_url, base_url, creation_date
    FROM ShortCut
    ORDER BY creation_date DESC;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetTotalAccessesByShortcut(IN p_short_code VARCHAR(10))
BEGIN
    DECLARE v_id INT;

    SELECT id_short_cut INTO v_id
    FROM ShortCut
    WHERE short_code = p_short_code;

    IF v_id IS NOT NULL THEN
        SELECT COUNT(*) AS total_access
        FROM AccessLog
        WHERE id_short_cut = v_id;
    ELSE
        SELECT 0 AS total_access;
    END IF;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetAccessesByDay(IN p_short_code VARCHAR(10))
BEGIN
    DECLARE v_id INT;

    SELECT id_short_cut INTO v_id
    FROM ShortCut
    WHERE short_code = p_short_code;

    IF v_id IS NOT NULL THEN
        SELECT DATE(access_date) AS day, COUNT(*) AS total
        FROM AccessLog
        WHERE id_short_cut = v_id
        GROUP BY day
        ORDER BY day;
    END IF;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetAccessesByCountry(IN p_short_code VARCHAR(10))
BEGIN
    DECLARE v_id INT;

    SELECT id_short_cut INTO v_id
    FROM ShortCut
    WHERE short_code = p_short_code;

    IF v_id IS NOT NULL THEN
        SELECT country, COUNT(*) AS total
        FROM AccessLog
        WHERE id_short_cut = v_id
        GROUP BY country;
    END IF;
END$$

DELIMITER ;

