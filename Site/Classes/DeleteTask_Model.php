<?php

declare(strict_types=1);

class DeleteTaskModel extends Dbh {

    protected function DeleteTaskFromDB(int $idDelete) {
        $query = "DELETE FROM tasks WHERE id = :idDelete;";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":idDelete", $idDelete);
        $stmt->execute();
    }

    protected function GetTask(int $idDelete) {
        $query = "SELECT id FROM tasks WHERE id = :idDelete;";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":idDelete", $idDelete);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
