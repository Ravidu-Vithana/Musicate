<?php

require "connection.php";

if (isset($_GET["c"])) {
    $c_name = $_GET["c"];

    $category_rs = Database::search("SELECT * FROM `category` WHERE `category_name` LIKE '%" . $c_name . "%'");
    $category_num = $category_rs->fetch_assoc();

    if ($category_num == 0) {
        Database::iud("INSERT INTO `category`(`category_name`) VALUES('" . $c_name . "')");
        echo ("success");
    } else {
        echo ("2");
    }
} else {
    echo ("1");
}
