<?php

require_once './config_session.inc.php';

if (isset($_SESSION["delete"])) {
    
    $idDelete = $_SESSION["delete"];
    unset($_SESSION["delete"]);

    require_once '../Classes/Dbh.php';
    require_once '../Classes/DeleteTask_Model.php';
    require_once '../Classes/DeleteTask_Contr.php';
    
    $DeleteTaskContr = new DeleteTaskContr($idDelete);

    $DeleteTaskContr->DeleteTask();

    header("Location: ../dashboard.php");
    die();

} else {
    header("Location: ../dashboard.php");
    die();
}