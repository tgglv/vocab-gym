USE vocab_gym;

GRANT INSERT, UPDATE, DELETE, SELECT on *.* TO 'vocab-gym-user'@'%';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `topics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Topic name',
  `method` varchar(100) NOT NULL DEFAULT 'one-way' COMMENT 'Method of testing',
  `is_completed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether topic is learned',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

