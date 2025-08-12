#!/bin/bash

# Check if path argument is provided
if [ $# -eq 0 ]; then
    echo "Usage: $0 <wordpress_path>"
    echo "Example: $0 /path/to/wordpress"
    exit 1
fi

WORDPRESS_PATH="$1"

echo "Running migrations"
cd "$WORDPRESS_PATH"

# Check if migrations table exists
echo "Checking if migrations table exists"
migrations_table_exists=$(wp db query "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'dfs_migrations'" --path="$WORDPRESS_PATH" --skip-column-names)

if [ "$migrations_table_exists" -eq "0" ]; then
    echo "Migrations table does not exist, creating it"
    wp db import migrations/seed.sql --path="$WORDPRESS_PATH"
    echo "Migrations table created"
else
    echo "Migrations table exists"
fi

# Get a list of all migration files (SQL files and plugin activation files)
shopt -s nullglob
all_migrations=(./migrations/*.sql ./migrations/activate-*)

# Process each migration file
for migration in "${all_migrations[@]}"; do
    # Get the migration name (filename without path)
    migration_name="${migration##*/}"
    
    # Check if migration has been applied
    applied=$(wp db query "SELECT COUNT(*) FROM dfs_migrations WHERE name='$migration_name'" --path="$WORDPRESS_PATH" --skip-column-names)
    
    if [ "$applied" -eq "0" ]; then
        echo "Running migration: $migration_name"
        
        # Check if this is a plugin activation migration
        if [[ "$migration_name" == activate-* ]]; then
            # Extract plugin name from filename (e.g., "activate-hello-dolly" -> "hello-dolly")
            plugin_name="${migration_name#activate-}"
            echo "Activating plugin: $plugin_name"
            
            # Use WP-CLI to activate the plugin
            wp plugin activate "$plugin_name" --path="$WORDPRESS_PATH"
            
            if [ $? -eq 0 ]; then
                echo "Plugin $plugin_name activated successfully"
            else
                echo "Warning: Failed to activate plugin $plugin_name"
            fi
        else
            # Check if there's a matching PHP script to enhance the SQL
            php_script="./migrations/${migration_name%.sql}.php"
            if [ -f "$php_script" ]; then
                echo "Found PHP enhancement script: ${migration_name%.sql}.php"
                
                # Create a temporary enhanced SQL file
                temp_sql="/tmp/enhanced_${migration_name}"
                
                # Run the PHP script to generate enhanced SQL
                php "$php_script" "$WORDPRESS_PATH" > "$temp_sql"
                
                if [ $? -eq 0 ]; then
                    echo "PHP script executed successfully, running enhanced SQL"
                    # Run the enhanced SQL migration
                    wp db query < "$temp_sql" --path="$WORDPRESS_PATH"
                    # Clean up temp file
                    rm "$temp_sql"
                else
                    echo "Warning: PHP script failed, falling back to original SQL"
                    wp db query < "$migration" --path="$WORDPRESS_PATH"
                fi
            else
                # Run as regular SQL migration
                wp db query < "$migration" --path="$WORDPRESS_PATH"
            fi
        fi
        
        # Record that we've run this migration
        wp db query "INSERT INTO dfs_migrations (name) VALUES ('$migration_name')" --path="$WORDPRESS_PATH"
        
        echo "Migration completed: $migration_name"
    else
        echo "Skipping already applied migration: $migration_name"
    fi
done
