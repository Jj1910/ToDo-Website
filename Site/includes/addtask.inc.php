<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $description = $_POST["description"];

    require_once './config_session.inc.php';
    require_once '../Classes/Dbh.php';
    require_once '../Classes/AddTask_Model.php';
    require_once '../Classes/AddTask_Contr.php';
    
    $AddTaskContr = new AddTaskContr($description, $_SESSION["user_id"]);

    $AddTaskContr->AddTask();

    $die();

} else {
    header("Location: ../dashboard.php");
    die();
}