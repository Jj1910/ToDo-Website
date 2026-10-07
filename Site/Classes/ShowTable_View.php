<?php

declare(strict_types=1);

class ShowTableView extends ShowTableContr {
    private $table;

    public function __construct(string $table) {
        $this->table = $table;
    }

    /** @return array<int, array<string, mixed>> */
    private function getTable(string $table, int $user_id) {
        return parent::retrieveTable($table, $user_id);
    }

    public function showTable() {
        $table = $this->getTable($this->table, (int)($_SESSION["user_id"] ?? 0));

        ob_start();

        if (count($table) === 0) {
            echo '<p class="Empty-Message">No tasks yet &ndash; add your first one above!</p>';
            return (string)ob_get_clean();
        }

        ?>
        <div class="Task-Table">
            <table>
                <tr>
                    <th class="Table-Header">Task Description</th>
                    <th class="Table-Header">Action</th>
                </tr>
                <?php foreach ($table as $task): ?>
                <tr class="Table-Row">
                    <td class="Description"><?php echo htmlspecialchars((string)$task["description"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <form class="Delete-Form" action="./includes/deletetask.inc.php" method="post">
                            <input type="hidden" name="id" value="<?php echo (int)$task["id"]; ?>">
                            <?php echo csrf_field(); ?>
                            <button class="Delete-Button" type="submit">Delete Task</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <?php
        return (string)ob_get_clean();
    }
}