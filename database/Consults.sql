-- NOTE THAT: 
-- If you will use any of these queries, make sure to replace the '?' with the actual shortcut_id you want to analyze.
-- So watch out!! xd

-- Total Accesses 
SELECT COUNT(*) FROM AccessLog;

-- Total Accesses Per URL
SELECT COUNT(*) AS total_access
FROM AccessLog
WHERE shortcut_id = ?;

-- Total Accesses Per Country
SELECT country, COUNT(*) AS total
FROM AccessLog
WHERE shortcut_id = ?
GROUP BY country
ORDER BY total DESC;

-- Total Accesses Per Day
SELECT DATE(access_date) AS day, COUNT(*) AS total
FROM AccessLog
WHERE shortcut_id = ?
GROUP BY day
ORDER BY day;

-- Countries 
SELECT country, COUNT(*) AS total
FROM AccessLog
WHERE shortcut_id = ?
GROUP BY country;

-- Delete all data (use with caution!!)
DELETE FROM AccessLog;
DELETE FROM ShortCut;

-- Increase the access count
UPDATE ShortCut
SET access_count = access_count + 1
WHERE id = ?;

-- Insert a new access log entry
INSERT INTO AccessLog (shortcut_id, access_date, country)
VALUES (?, NOW(), ?);

-- Insert a new ShortCut entry
INSERT INTO ShortCut (short_code, original_url, base_url)
VALUES (?, ?, ?);

-- Get id_shortcut when user is trying to access a short URL
SELECT id_short_cut
FROM ShortCut
WHERE short_code = ?;