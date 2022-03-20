USE vocab_gym;

GRANT INSERT, UPDATE, DELETE, SELECT on *.* TO 'vocab-gym-user'@'%';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `topics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Topic name',
  `method` varchar(100) NOT NULL DEFAULT 'one-way' COMMENT 'Method of testing',
  `is_completed` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether topic is learned',
  `questions_per_attempt` tinyint(1) unsigned NOT NULL DEFAULT 10 COMMENT 'Number of questions per attempt',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(20) unsigned NOT NULL COMMENT 'Topic ID',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT 'The content of the question',
  `correct_answer` varchar(255) NOT NULL DEFAULT '' COMMENT 'The correct answer for the question',
  `is_learned` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether a question is learned',
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_topic_id` (`topic_id`,`content`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `attempts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` bigint(20) unsigned NOT NULL COMMENT 'Topic ID',
  `date_created` timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT 'Creation data of the attempt',
  `is_answered` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether an attempt is answered',  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `attempt_answers` (
  `attempt_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint(20) unsigned NOT NULL COMMENT 'Topic ID',
  `answer` VARCHAR(255) DEFAULT '' NOT NULL COMMENT 'User defined answer',
  `is_correct` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether an answer is correct',
  PRIMARY KEY (`attempt_id`, `question_id` )
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

