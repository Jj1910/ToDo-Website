<?php

declare(strict_types=1);

class Dbh {
    protected function connect (): PDO {
        // Read from the environment (docker-compose injects these).  The
        // defaults mirror docker-compose.yml, so the app still works even
        // if the variables are absent.
        $host     = getenv('MYSQL_HOST')     ?: 'ToDoDB';
        $dbname   = getenv('MYSQL_DATABASE') ?: 'todo_site';
        $dbuser   = getenv('MYSQL_USER')     ?: 'todo_user';
        $dbpass   = getenv('MYSQL_PASSWORD') ?: 'SuperSecurePassword';

        try {
            $pdo = new PDO(
                "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8mb4",
                $dbuser,
                $dbpass,
                [
                    // Fail fast with exceptions.
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    // Associative rows by default (less boilerplate, one fewer
                    // per-fetch call).
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // Real server-side prepared statements: safer and faster
                    // than the default client-side emulation.
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
            return $pdo;
        } catch (PDOException $e) {
            // Log the details server-side, never show them to the browser.
            error_log('DB connection failed: ' . $e->getMessage());
            http_response_code(500);
            echo 'Database connection failed. Please try again later.';
            exit;
        }
    }
}
