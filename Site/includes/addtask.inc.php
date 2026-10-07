<?php

declare(strict_types=1);

if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
    header("Location: ../dashboard.php");
    exit;
}

require_once __DIR__ . '/config_session.inc.php';

// Not logged in?  Send back to the login page instead of crashing on a
// missing session value.
if (empty($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}

$description = trim((string)($_POST["description"] ?? ""));

require_once __DIR__ . '/../Classes/Dbh.php';
require_once __DIR__ . '/../Classes/AddTask_Model.php';
require_once __DIR__ . '/../Classes/AddTask_Contr.php';

verify_csrf();

$AddTaskContr = new AddTaskContr($description, (int)$_SESSION["user_id"]);
$AddTaskContr->AddTask(); // always ends in header() + exit