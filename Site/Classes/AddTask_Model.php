<?php

declare(strict_types=1);

class AddTaskModel extends Dbh {

    protected function AddTaskToDB(string $description, int $user_id) {
        $query = "INSERT INTO tasks (description, user_id) VALUES (:description, :user_id);";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }
}