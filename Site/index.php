<?php
require_once __DIR__ . '/includes/config_session.inc.php';

if (isset($_SESSION["user_id"])) {
    header("Location: ./dashboard.php");
    exit;
}

$error = $_GET["error"] ?? "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/main.css">
    <title>To Do Site</title>
</head>

<body>

    <div class="Header-Login">
        <h1>Login</h1>
    </div>

    <div class="Login-Form">
        <?php if ($error === "inputempty"): ?>
            <p class="Flash-Error">Please Fill Out All Fields!</p>
        <?php elseif ($error === "invalidlogon"): ?>
            <p class="Flash-Error">Invalid Credentials!</p>
        <?php endif; ?>

        <form action="includes/login.inc.php" method="post">
            <input class="Login-Username" required type="text" name="username" placeholder="Username">
            <input class="Login-Password" required type="password" name="pwd" placeholder="Password">
            <?php echo csrf_field(); ?>
            <button class="Login-Button">Login</button>
        </form>
    </div>

</body>

</html>