<?php

declare(strict_types=1);

Class ShowTableContr extends ShowTableModel {
    
    protected function isValidTable (string $table, string $user_id) {
        try {
            parent::getData($table, $user_id);
            return true;
        } catch (PDOException $e) {
            echo "Error getting table: " . $e->getMessage();
            return false; 
        }
    }

    protected function retrieveTable (string $table, string $user_id){
        if ($this->isValidTable($table, $user_id)) {
            return parent::getData($table, $user_id);
        } else {
            return "";
        }
    }
}
