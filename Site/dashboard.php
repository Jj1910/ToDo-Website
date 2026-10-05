<?php
require_once 'includes/config_session.inc.php';

if(!isset($_SESSION["user_id"])) {
    header("Location: ./index.php");
    die();
}
if($_GET){
    if (isset($_GET["error"])) {
        if($_GET["error"] === "inputempty") {
            echo "<p>Please Fill out all Fields!</p>";
        }
        if($_GET["error"] === "false") {
            echo "<h2>Task Successfully Created!</h2>";
        }
        if($_GET["error"] === "falseId") {
            echo "<h2>Task Successfully Deleted!</h2>";
        }
        if($_GET["error"] === "noId") {
            echo "<p>Task Somehow Doesn't Exist!</p>";
        }
    }
    if (isset($_GET["delete"])){
        $_SESSION["delete"] = $_GET["delete"];
        header("Location: includes/deletetask.inc.php");
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>To Do Dashboard</title>
</head>

<body>
    <div class="Header-Dashboard">
        <h1>To Do!</h1>
    </div>

    <div class="Task-Form">
        <form action="includes/addtask.inc.php" method="post">
            <input class="Task-Description" required type="text" name="description" placeholder="Task Description">
            <button class="Add-Task">Add Task</button>
        </form>
    </div>
    
    <?php
        require_once 'includes/show_table.inc.php';
    ?>

    <div class="Logout-Form">
        <form action="includes/logout.inc.php" method="post">
            <button class="Logout-Button">Logout</button>
        </form>
    </div>
</body>

</html>
