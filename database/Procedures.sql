
-- This file contains stored procedures for analyzing access logs in the database.
-- These procedures were done with based on the queries in Consults.sql, but now they are encapsulated in procedures for easier reuse and better organization.

DELIMITER $$

CREATE PROCEDURE GetTotalAccesses()
BEGIN
    SELECT COUNT(*) AS total_accesses
    FROM AccessLog;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetTotalAccessesByShortcut(IN p_shortcut_id INT)
BEGIN
    SELECT COUNT(*) AS total_access
    FROM AccessLog
    WHERE shortcut_id = p_shortcut_id;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetAccessesByCountry(IN p_shortcut_id INT)
BEGIN
    SELECT country, COUNT(*) AS total
    FROM AccessLog
    WHERE shortcut_id = p_shortcut_id
    GROUP BY country
    ORDER BY total DESC;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetAccessesByDay(IN p_shortcut_id INT)
BEGIN
    SELECT DATE(access_date) AS day, COUNT(*) AS total
    FROM AccessLog
    WHERE shortcut_id = p_shortcut_id
    GROUP BY day
    ORDER BY day;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetCountries(IN p_shortcut_id INT)
BEGIN
    SELECT country, COUNT(*) AS total
    FROM AccessLog
    WHERE shortcut_id = p_shortcut_id
    GROUP BY country;
END$$

DELIMITER ;

-- HOW TO CALL THEM!!!
-- CALL GetTotalAccesses();
-- CALL GetTotalAccessesByShortcut(1);
-- CALL GetAccessesByCountry(1);
-- CALL GetAccessesByDay(1);
-- CALL GetCountries(1);