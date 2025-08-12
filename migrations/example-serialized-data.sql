-- Example Migration: Complex Data Setup
-- This migration will be enhanced by example-serialized-data.php
-- The PHP script will generate additional SQL with serialized data

-- Basic table structure (this runs first)
CREATE TABLE IF NOT EXISTS wp_example_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- The PHP script will append serialized options data here
-- This allows for complex data structures that are hard to maintain in pure SQL
