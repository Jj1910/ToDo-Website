-- =====================================================================
--  db/init.sql
--  This file is mounted into the MySQL container's
--  /docker-entrypoint-initdb.d/ directory and runs ONCE, the first time
--  the database starts with an empty data directory.  It is idempotent
--  (CREATE TABLE IF NOT EXISTS / upsert), so it is safe to re-run.
--
--  To force a completely fresh database later:
--      docker compose down
--      rm -rf data
--      docker compose up -d
-- =====================================================================

CREATE TABLE IF NOT EXISTS users (
    id          INT(11)       NOT NULL AUTO_INCREMENT,
    username    VARCHAR(50)   NOT NULL,
    pwd         VARCHAR(255)  NOT NULL,
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_users_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS tasks (
    id           INT(11)       NOT NULL AUTO_INCREMENT,
    description  VARCHAR(255)  NOT NULL,
    user_id      INT(11)       NOT NULL,
    created_at   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_tasks_user_id (user_id),
    CONSTRAINT fk_tasks_user
        FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default account.  Username: admin   Password: admin123
-- CHANGE THIS PASSWORD after first login (see README).
INSERT INTO users (username, pwd)
VALUES ('admin', '$2y$10$AWvYoEh.sWzDNP9QirNAx.KuQsG6ID/iaWg0IgsUtURvMGMgpWUbK')
ON DUPLICATE KEY UPDATE username = username;
