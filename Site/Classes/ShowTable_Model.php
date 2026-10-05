<?php

declare(strict_types=1);

class ShowTableModel extends Dbh {

    protected function getData(string $tableName, string $user_id) {
        $query = "SELECT * FROM " . $tableName . " WHERE user_id = :user_id;";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); #PDO::FETCH_ASSOC
        return $result;
    }
}
