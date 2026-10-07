<?php
require_once __DIR__ . '/includes/config_session.inc.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ./index.php");
    exit;
}

// One-shot messages passed around via the ?error= query parameter.
$flash = null;
switch ($_GET["error"] ?? "") {
    case "inputempty":
        $flash = ["type" => "Flash-Error", "text" => "Please Fill out all Fields!"];
        break;
    case "toolong":
        $flash = ["type" => "Flash-Error", "text" => "Task Description Too Long!"];
        break;
    case "false":
        $flash = ["type" => "Flash-Success", "text" => "Task Successfully Created!"];
        break;
    case "falseId":
        $flash = ["type" => "Flash-Success", "text" => "Task Successfully Deleted!"];
        break;
    case "noId":
        $flash = ["type" => "Flash-Error", "text" => "Task Somehow Doesn't Exist!"];
        break;
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
        <p class="Welcome">Logged in as <?php echo htmlspecialchars((string)($_SESSION["user_username"] ?? ""), ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <div class="Task-Form">
        <?php if ($flash !== null): ?>
            <p class="<?php echo $flash["type"]; ?>"><?php echo $flash["text"]; ?></p>
        <?php endif; ?>

        <form action="includes/addtask.inc.php" method="post">
            <input class="Task-Description" required maxlength="255" type="text" name="description" placeholder="Task Description">
            <?php echo csrf_field(); ?>
            <button class="Add-Task">Add Task</button>
        </form>
    </div>

    <?php
        require_once __DIR__ . '/includes/show_table.inc.php';
    ?>

    <div class="Logout-Form">
        <form action="includes/logout.inc.php" method="post">
            <?php echo csrf_field(); ?>
            <button class="Logout-Button">Logout</button>
        </form>
    </div>
</body>

</html>