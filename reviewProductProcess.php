<?php

session_start();
require "connection.php";

if (isset($_GET["count"]) && isset($_GET["comment"]) && isset($_GET["item_id"])) {

    $reviews = Database::search("SELECT * FROM `product_reviews` WHERE `item_id`='" . $_GET["item_id"] . "'");

    $item = Database::search("SELECT * FROM `items` 
    INNER JOIN `variant` ON `variant`.`id` = `items`.`variant_id` 
    WHERE `item_id`='" . $_GET["item_id"] . "'");
    $item_data = $item->fetch_assoc();

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if ($reviews->num_rows == 0) {
        Database::iud("INSERT INTO `product_reviews` (`description`,`date_time`,`product_id`,`variant_id`,`user_email`,`star_count`,`item_id`) 
        VALUES ('" . $_GET["comment"] . "','" . $date . "','" . $item_data["product_id"] . "','" . $item_data["variant_id"] . "','" . $_SESSION["user"]["email"] . "','" . $_GET["count"] . "','" . $_GET["item_id"] . "')");

        echo("success1");
    } else {
        Database::iud("UPDATE `product_reviews` SET `description` = '" . $_GET["comment"] . "',`star_count`='" . $_GET["count"] . "' 
        WHERE `item_id` = '" . $_GET["item_id"] . "'");
        echo("success2");
    }
}else{
    echo("1");
}
