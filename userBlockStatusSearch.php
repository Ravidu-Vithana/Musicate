<?php

require "connection.php";

if (isset($_GET["email"])) {

    $email = $_GET["email"];

    $search = Database::search("SELECT * FROM `user` WHERE `email` = '$email'");
    if ($search->num_rows == 1) {

        $searchData = $search->fetch_assoc();

        echo ($searchData["status"] == 1 ? "active" : "blocked");
    } else {
        echo ("1");
    }
} else {
    echo ("1");
}
