<?php

declare(strict_types=1);

class DeleteTaskContr extends DeleteTaskModel {
    private $idDelete;
    private $userId;

    public function __construct(int $idDelete, int $userId) {
        $this->idDelete = $idDelete;
        $this->userId = $userId;
    }

    public function DeleteTask() {
        $deleted = parent::DeleteTaskFromDB($this->idDelete, $this->userId);

        if ($deleted === 0) {
            // Either the task doesn't exist or it isn't this user's task.
            // Deliberately the same message for both, so ids can't be
            // probed across accounts.
            header("Location: ../dashboard.php?error=noId");
        } else {
            header("Location: ../dashboard.php?error=falseId");
        }
        exit;
    }
}