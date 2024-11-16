<?php

require "connection.php";

if (isset($_GET["b"]) && isset($_GET["c"]) && isset($_GET["sc"])) {
    $b_name = $_GET["b"];
    $cid = $_GET["c"];
    $scid = $_GET["sc"];

    $brand_rs = Database::search("SELECT * FROM `brand` WHERE `brand_name` = '" . $b_name . "'");
    $brand_num = $brand_rs->num_rows;

    if ($brand_num == 0) {

        Database::iud("INSERT INTO `brand`(`brand_name`) VALUES('" . $b_name . "')");
        $new_brand_id = Database::$connection->insert_id;

        Database::iud("INSERT INTO `brand_has_category`(`brand_id`,`category_id`,`sub_categories_id`) VALUES('" . $new_brand_id . "','" . $cid . "','" . $scid . "')");

        echo ("success");
    } else {

        $brand_data = $brand_rs->fetch_assoc();
        $brand_id = $brand_data["id"];

        $brand_has_category_rs = Database::search("SELECT * FROM `brand_has_category` WHERE `brand_id` = '" . $brand_id . "' AND `category_id` = '" . $cid . "' 
        AND `sub_categories_id` = '" . $scid . "'");
        $brand_has_category_num = $brand_has_category_rs->num_rows;

        if ($brand_has_category_num > 0) {
            echo ("2");
        } else {
            Database::iud("INSERT INTO `brand_has_category`(`brand_id`,`category_id`,`sub_categories_id`) VALUES('" . $brand_id . "','" . $cid . "','" . $scid . "')");
            echo ("success");
        }
    }
} else {
    echo ("1");
}
