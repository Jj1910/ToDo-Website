<?php

declare(strict_types=1);

use function PHPSTORM_META\type;

Class ShowTableView extends ShowTableContr {
    private $table;
    
    public function __construct(string $table) {
        $this->table = $table;
    }

    private function getTable(string $table, string $user_id) {
        return parent::retrieveTable($table, $user_id);
    }

    public function showTable() {
        $table = $this->getTable($this->table, $_SESSION["user_id"]);
        if (count($table) > 0){
            ob_start(); ?>
            <div class="Task-Table">
                <table border = '2'>
                    <th class="Table-Header">Task Description</th>
                    <th class="Table-Header">Action</th>
                    <?php
                    foreach ($table as $array => $task) {
                        echo "<tr class=\"Table-Row\">";
                        echo "<td class=\"Description\">" . htmlspecialchars($task["description"]) . "</td>";
                        ?>
                        <td>
                            <form class="Delete-Form" action="./dashboard.php?delete=" method="GET">
                                <input type="hidden" name="delete" value="<?php echo $task["id"] ?>" />
                                <button class="Delete-Button" type="submit">Delete Task</button>
                            </form>
                        </td>
                        <?php
                        
                    }
                        echo "</tr>";
                    ?>
                </table>
            </div>
        <?php 
        return ob_get_clean();
        }
    }
}
