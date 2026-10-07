<?php

declare(strict_types=1);

class AddTaskContr extends AddTaskModel {
    // Must match the VARCHAR(255) column in db/init.sql.
    private const MAX_DESCRIPTION_LENGTH = 255;

    private $description;
    private $user_id;

    public function __construct(string $description, int $user_id) {
        $this->description = $description;
        $this->user_id = $user_id;
    }

    private function is_input_empty() {
        return trim($this->description) === '';
    }

    private function is_too_long() {
        return mb_strlen($this->description) > self::MAX_DESCRIPTION_LENGTH;
    }

    public function AddTask() {
        if ($this->is_input_empty()) {
            header("Location: ../dashboard.php?error=inputempty");
            exit;
        }
        if ($this->is_too_long()) {
            header("Location: ../dashboard.php?error=toolong");
            exit;
        }

        parent::AddTaskToDB(trim($this->description), $this->user_id);

        header("Location: ../dashboard.php?error=false");
        exit;
    }
}