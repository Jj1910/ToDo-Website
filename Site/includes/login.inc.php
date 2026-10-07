<?php

declare(strict_types=1);

if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
    header("Location: ../index.php");
    exit;
}

$username = trim((string)($_POST["username"] ?? ""));
$pwd = (string)($_POST["pwd"] ?? "");

require_once __DIR__ . '/config_session.inc.php';
require_once __DIR__ . '/../Classes/Dbh.php';
require_once __DIR__ . '/../Classes/SignIn_Model.php';
require_once __DIR__ . '/../Classes/SignIn_Contr.php';

// Reject cross-site login form submissions before touching the database.
verify_csrf();

$signInContr = new SignInContr($username, $pwd);
$signInContr->signInUser(); // always ends in header() + exit