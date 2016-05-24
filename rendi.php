<?php

require_once('funk.php');
session_start();
connect_db();

$page = "pealeht";
if (isset($_GET['page']) && $_GET['page'] != "") {
    $page = htmlspecialchars($_GET['page']);
}

include_once('views/head.html');

switch ($page) {
    case "login":
        logi();
        break;

    case "logout":
        logout();
        break;

    case "asjad":
        
        asjad();
        break;

    case "rendi":
        rendi();
        break;

    case "lisa":
        lisa();
        break;

    case "muuda":
        muuda();
        break;

    default:
        include_once('views/pealeht.php');
        break;
}

include_once('views/foot.html');
?>