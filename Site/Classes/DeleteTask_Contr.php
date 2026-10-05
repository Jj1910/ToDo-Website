<?php

declare(strict_types=1);

Class DeleteTaskContr extends DeleteTaskModel {
    private $idDelete;
    
    public function __construct(int $idDelete) {
        $this->idDelete = $idDelete;
    }

    private function TaskExists(int $idDelete) {
        $result = parent::GetTask($idDelete);
        return $result;
    }

    public function DeleteTask(){
        if (!$this->TaskExists($this->idDelete)){
            header("Location: ../dashboard.php?error=noId");
            die();
        }

        parent::DeleteTaskFromDB($this->idDelete);

        header("Location: ../dashboard.php?error=falseId");
        die();
    }
}