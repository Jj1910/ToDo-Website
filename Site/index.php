<?php
require_once 'includes/config_session.inc.php';

if(isset($_SESSION["user_id"])) {
    exit(header("Location: ./dashboard.php"));
    #die();
} 

if ($_GET){
    if ($_GET["error"] === "inputempty"){
        echo "<p>Please Fill Out All Fields!</p>";
    } else if ($_GET["error"] === "invalidlogon") {
        echo "<p>Invalid Credentials!</p>";
    }
}
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
        <form action="includes/login.inc.php" method="post">
            <input class="Login-Username" required type="text" name="username" placeholder="Username">
            <input class="Login-Password" required type="password" name="pwd" placeholder="Password">
            <button class="Login-Button">Login</button>
        </form>
    </div>

</body>

</html>
