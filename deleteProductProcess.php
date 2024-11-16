<?php

require "connection.php";

if (isset($_GET["product_id"])) {

    $product_id = $_GET["product_id"];

    Database::iud("UPDATE `product` SET `status` = '2' WHERE `id` = '$product_id'");

    echo ("success");
} else {
    echo ("1");
}
