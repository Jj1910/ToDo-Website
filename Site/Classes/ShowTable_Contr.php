<?php

declare(strict_types=1);

class ShowTableContr extends ShowTableModel {

    /**
     * Fetch the table in ONE query (the old validate-then-fetch pattern ran
     * the same query twice per page load).  On error the details are logged
     * server-side and an empty array is returned instead of leaking error
     * text into the page.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function retrieveTable(string $table, int $user_id) {
        try {
            return parent::getData($table, $user_id);
        } catch (PDOException $e) {
            error_log('Error fetching table "' . $table . '": ' . $e->getMessage());
            return [];
        }
    }
}