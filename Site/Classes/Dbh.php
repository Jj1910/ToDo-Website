<?php

class Dbh {
    private $host = "ToDoDB";
    private $dbname = "todo_site";
    private $dbusername = "todo_user";
    private $dbpassword = "SuperSecurePassword";

    protected function connect () {
        try {
            $pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->dbusername, $this->dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }
}
