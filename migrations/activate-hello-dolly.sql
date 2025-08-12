-- Migration: Activate Hello Dolly Plugin
-- This migration activates the Hello Dolly plugin in WordPress
-- Note: Hello Dolly comes with WordPress core, so we just need to activate it

-- Get current active plugins (using the same prefix as migrations table)
SET @current_active_plugins = (SELECT option_value FROM dfs_options WHERE option_name = 'active_plugins' LIMIT 1);

-- If no active plugins exist, create the option
INSERT INTO dfs_options (option_name, option_value, autoload) 
SELECT 'active_plugins', 'a:1:{s:12:"hello-dolly/hello.php";s:0:"";}', 'yes'
WHERE NOT EXISTS (SELECT 1 FROM dfs_options WHERE option_name = 'active_plugins');

-- If active plugins exist, add hello-dolly to the list
UPDATE dfs_options 
SET option_value = CASE 
    WHEN option_value = '' OR option_value IS NULL THEN 'a:1:{s:12:"hello-dolly/hello.php";s:0:"";}'
    WHEN option_value NOT LIKE '%hello-dolly%' THEN CONCAT(SUBSTRING(option_value, 1, LENGTH(option_value)-1), ',s:12:"hello-dolly/hello.php";s:0:"";}')
    ELSE option_value
END
WHERE option_name = 'active_plugins' AND option_value != '' AND option_value IS NOT NULL;
