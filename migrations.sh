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

# Get a list of all migration files
shopt -s nullglob
all_migrations=(./migrations/*.sql)

# Process each migration file
for migration in "${all_migrations[@]}"; do
    # Get the migration name (filename without path)
    migration_name="${migration##*/}"
    
    # Check if migration has been applied
    applied=$(wp db query "SELECT COUNT(*) FROM dfs_migrations WHERE name='$migration_name'" --path="$WORDPRESS_PATH" --skip-column-names)
    
    if [ "$applied" -eq "0" ]; then
        echo "Running migration: $migration_name"
        
        # Run the migration
        wp db query < "$migration" --path="$WORDPRESS_PATH"
        
        # Record that we've run this migration
        wp db query "INSERT INTO dfs_migrations (name) VALUES ('$migration_name')" --path="$WORDPRESS_PATH"
        
        echo "Migration completed: $migration_name"
    else
        echo "Skipping already applied migration: $migration_name"
    fi
done
