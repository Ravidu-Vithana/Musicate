<?php

session_start();
require "connection.php";

if (isset($_GET["p_id"]) && isset($_GET["status"])) {

    $product_id = $_GET["p_id"];
    $product_status = $_GET["status"];
    $adminEmail = $_SESSION["admin"]["email"];

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if ($product_status == "active") {

        if (isset($_GET["reason"])) {

            $reason = $_GET["reason"];

            if (empty($reason)) {
                echo ("Please enter the reason for deactivating this product.");
            } else {
                $product = Database::search("SELECT * FROM `product` WHERE `id` = '$product_id'");
                if ($product->num_rows == 1) {

                    Database::iud("INSERT INTO `product_deactivation_history`(`description`,`product_id`,`admin_email`,`date_time`) VALUES('$reason','$product_id','$adminEmail','$date');");

                    Database::iud("UPDATE `product` SET `status` = '0' WHERE `id` = '$product_id'");
                    echo ("deactivated");
                } else {
                    echo ("1");
                }
            }
        } else {
            echo ("1");
        }
    } else {

        $product = Database::search("SELECT * FROM `product` WHERE `id` = '$product_id'");
        if ($product->num_rows == 1) {

            Database::iud("UPDATE `product` SET `status` = '1' WHERE `id` = '$product_id'");
            echo ("active");
        } else {
            echo ("1");
        }
    }
} else {
    echo ("1");
}
