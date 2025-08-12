CREATE TABLE IF NOT EXISTS `dfs_migrations` (
  `name` varchar(255) PRIMARY KEY,
  `applied_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `dfs_migrations` (`name`) VALUES
('seed.sql');
