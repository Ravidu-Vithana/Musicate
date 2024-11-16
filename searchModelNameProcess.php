<?php

require "connection.php";

if (isset($_GET["mid"])) {

    $mid = $_GET["mid"];

    if ($mid > '0') {
        $model_rs = Database::search("SELECT * FROM `model` WHERE `id` = '" . $mid . "'");
        $model_num = $model_rs->num_rows;

        if ($model_num == 1) {
            $model_data = $model_rs->fetch_assoc();
            $brand_rs = Database::search("SELECT * FROM `brand` WHERE `id` = '" . $model_data["brand_id"] . "'");
            $brand_num = $brand_rs->num_rows;

            if ($brand_num == 1) {
                $brand_data = $brand_rs->fetch_assoc();

                echo ($brand_data["brand_name"] . " " . $model_data["model_name"]);
            } else {
                echo ("1");
            }
        } else {
            echo ("1");
        }
    }
} else {
    echo ("1");
}
