-- HOW TO CALL THEM

-- Insert a new shortcut
-- CALL InsertShortCut('abc123', 'https://www.google.com', 'https://tuapp.com/');

-- Register an access using the short_code
-- CALL InsertAccessLogByCode('abc123', '192.168.1.1', 'CR');

-- Get total accesses (global)
-- CALL GetTotalAccesses();

-- Get total accesses by shortcut (using short_code)
-- CALL GetTotalAccessesByShortcut('abc123');

-- Get accesses grouped by day
-- CALL GetAccessesByDay('abc123');

-- Get accesses grouped by country
--CALL GetAccessesByCountry('abc123');

-- Delete all data (use with caution)
--CALL DeleteAllData();

-- Get all shortcuts
--CALL GetAllShortCuts();

-- Get total accesses for all shortcuts
--CALL GetAccessCountForAllShortCuts();

-- =========================
-- TESTING SECTION
-- =========================

-- Insert sample shortcuts
--CALL InsertShortCut('abc123', 'https://www.google.com', 'https://tuapp.com/');
--CALL InsertShortCut('xyz789', 'https://www.youtube.com', 'https://tuapp.com/');
--CALL InsertShortCut('test01', 'https://www.github.com', 'https://tuapp.com/');

-- Verify inserted shortcuts
--SELECT * FROM ShortCut--;

-- Insert sample access logs
--CALL InsertAccessLogByCode('abc123', '192.168.1.1', 'CR');
--CALL InsertAccessLogByCode('abc123', '192.168.1.2', 'CR');
--CALL InsertAccessLogByCode('abc123', '192.168.1.3', 'US');

--CALL InsertAccessLogByCode('xyz789', '192.168.1.4', 'MX');
--CALL InsertAccessLogByCode('xyz789', '192.168.1.5', 'MX');

--CALL InsertAccessLogByCode('test01', '192.168.1.6', 'CR');

-- View access logs
--SELECT * FROM AccessLog;

-- Global total accesses
--CALL GetTotalAccesses();

-- Total accesses by shortcut
--CALL GetTotalAccessesByShortcut('abc123');
--CALL GetTotalAccessesByShortcut('xyz789');
--CALL GetTotalAccessesByShortcut('test01');

-- Accesses grouped by day
--CALL GetAccessesByDay('abc123');

-- Accesses grouped by country
--CALL GetAccessesByCountry('abc123');

-- Get all shortcuts
--CALL GetAllShortCuts();