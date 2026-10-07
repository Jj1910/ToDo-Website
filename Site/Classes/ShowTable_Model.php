<?php

declare(strict_types=1);

class ShowTableModel extends Dbh {

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function getData(string $tableName, int $user_id) {
        // Only plain identifiers (defense in depth — callers pass a hard-coded
        // name, but never trust anyway).
        if (!preg_match('/^[A-Za-z0-9_]+$/', $tableName)) {
            throw new InvalidArgumentException('Invalid table name: ' . $tableName);
        }

        $query = "SELECT id, description, created_at FROM " . $tableName
               . " WHERE user_id = :user_id ORDER BY created_at DESC, id DESC;";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}