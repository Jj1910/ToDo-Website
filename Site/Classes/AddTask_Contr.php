<?php

declare(strict_types=1);

Class AddTaskContr extends AddTaskModel {
    private $description;
    private $user_id;
    
    public function __construct(string $description, int $user_id) {
        $this->description = $description;
        $this->user_id = $user_id;
    }

    private function is_input_empty() {
        if (empty($this->description)){
            return true;
        } else {
            return false;
        }
    }

    public function AddTask(){
        if ($this->is_input_empty()){
            header("Location: ../dashboard.php?error=inputempty");
            die();
        }

        parent::AddTaskToDB($this->description, $this->user_id);

        header("Location: ../dashboard.php?error=false");
        die();
    }
}