<?php

declare(strict_types=1);

if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
    header("Location: ../dashboard.php");
    exit;
}

require_once __DIR__ . '/config_session.inc.php';

if (empty($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}

verify_csrf();

// Wipe the server-side data, then expire the session cookie client-side.
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires'  => time() - 42000,
        'path'     => $p["path"],
        'domain'   => $p["domain"],
        'secure'   => $p["secure"],
        'httponly' => $p["httponly"],
        'samesite' => $p["samesite"],
    ]);
}

session_destroy();

header("Location: ../index.php");
exit;