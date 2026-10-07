<?php

require_once __DIR__ . '/../Classes/Dbh.php';
require_once __DIR__ . '/../Classes/ShowTable_Model.php';
require_once __DIR__ . '/../Classes/ShowTable_Contr.php';
require_once __DIR__ . '/../Classes/ShowTable_View.php';

$showTableView = new ShowTableView("tasks");

echo $showTableView->showTable();