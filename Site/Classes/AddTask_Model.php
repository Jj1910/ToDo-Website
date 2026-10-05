<?php

declare(strict_types=1);

class AddTaskModel extends Dbh {
    private $description;

    protected function AddTaskToDB(string $description, int $user_id) {
        $query = "INSERT INTO tasks (description, user_id) VALUES (:description, :user_id);";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
    }
}