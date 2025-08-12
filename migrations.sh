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
