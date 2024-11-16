<?php

session_start();

if (isset($_GET["acc_type"])) {

    $acc_type = $_GET["acc_type"];

    if (isset($_SESSION["user"]) && $acc_type == "user") {
        $_SESSION["user"] = null;
        session_destroy();
        echo ("success");
    } else if (isset($_SESSION["admin"]) && $acc_type == "admin") {
        $_SESSION["admin"] = null;
        session_destroy();
        echo ("success");
    } else {
        echo ("1");
    }
} else {
    echo ("1");
}
