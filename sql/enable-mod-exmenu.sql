UPDATE test_modules
    SET published = 1,
        position = 'sidebar-right'
    WHERE module = 'mod_exmenu';

INSERT IGNORE INTO test_modules_menu(moduleid, menuid)
SELECT id, 0
FROM test_modules
WHERE module = 'mod_exmenu';
