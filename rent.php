<?php

require_once('funk.php');
session_start();


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

    case "rendi_valja":
       rendi_valja();
        break;

    case "lisa":
        lisa();
        break;

    case "kustuta":
        kustuta();
        break;

    default:
        pealeht();
        break;
}

include_once('views/foot.html');
?>