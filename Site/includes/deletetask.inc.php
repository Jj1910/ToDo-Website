<?php

declare(strict_types=1);

// Deletion is a POST carrying a CSRF token (it used to be a bare GET, which
// let any cross-site link force a deletion).
if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
    header("Location: ../dashboard.php");
    exit;
}

require_once __DIR__ . '/config_session.inc.php';

if (empty($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}

$id = (int)($_POST["id"] ?? 0);

require_once __DIR__ . '/../Classes/Dbh.php';
require_once __DIR__ . '/../Classes/DeleteTask_Model.php';
require_once __DIR__ . '/../Classes/DeleteTask_Contr.php';

verify_csrf();

if ($id <= 0) {
    header("Location: ../dashboard.php?error=noId");
    exit;
}

$DeleteTaskContr = new DeleteTaskContr($id, (int)$_SESSION["user_id"]);
$DeleteTaskContr->DeleteTask(); // always ends in header() + exit