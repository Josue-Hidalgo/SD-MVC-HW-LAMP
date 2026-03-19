-- NOTE THAT: -- If you will use any of these queries, make sure to replace the '?' with the actual shortcut_id you want to analyze. 
-- So watch out!! xd

-- Total Accesses 
SELECT COUNT(*) AS total_accesses
FROM AccessLog;


-- Total Accesses Per URL
SELECT COUNT(*) AS total_access
FROM AccessLog
WHERE id_short_cut = ?;


-- Total Accesses Per Country
SELECT country, COUNT(*) AS total
FROM AccessLog
WHERE id_short_cut = ?
GROUP BY country
ORDER BY total DESC;


-- Total Accesses Per Day
SELECT DATE(access_date) AS day, COUNT(*) AS total
FROM AccessLog
WHERE id_short_cut = ?
GROUP BY day
ORDER BY day;


-- Countries 
SELECT country, COUNT(*) AS total
FROM AccessLog
WHERE id_short_cut = ?
GROUP BY country;


-- Delete all data (use with caution!!)
DELETE FROM AccessLog;
DELETE FROM ShortCut;


-- Insert a new access log entry (usando short_code directamente)
INSERT INTO AccessLog (id_short_cut, ip_address, country)
SELECT id_short_cut, ?, ?
FROM ShortCut
WHERE short_code = ?;


-- Insert a new ShortCut entry
INSERT INTO ShortCut (short_code, original_url, base_url)
VALUES (?, ?, ?);


-- Get id_shortcut when user is trying to access a short URL
SELECT id_short_cut
FROM ShortCut
WHERE short_code = ?;