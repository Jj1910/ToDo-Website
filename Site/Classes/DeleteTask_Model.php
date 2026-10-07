<?php

declare(strict_types=1);

class DeleteTaskModel extends Dbh {

    /**
     * Delete a task, but ONLY if it belongs to the given user.  Without the
     * user_id check any logged-in user could delete any other user's task
     * simply by guessing ids (IDOR).
     *
     * @return int number of rows actually deleted (0 = not found / not owner)
     */
    protected function DeleteTaskFromDB(int $idDelete, int $userId) {
        $query = "DELETE FROM tasks WHERE id = :idDelete AND user_id = :userId;";
        $stmt = parent::connect()->prepare($query);
        $stmt->bindParam(":idDelete", $idDelete, PDO::PARAM_INT);
        $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->rowCount();
    }
}