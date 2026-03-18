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

