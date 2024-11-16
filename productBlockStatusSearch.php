<?php

require "connection.php";

if (isset($_GET["p_id"])) {

    $product_id = $_GET["p_id"];

    $result = Database::search("SELECT * FROM `product` WHERE `id` = '$product_id'");

    if ($result->num_rows == 1) {

        $result_data = $result->fetch_assoc();

        echo ($result_data["status"] == 1 ? "active" : "deactive");
    } else {
        echo ("1");
    }
} else {
    echo ("1");
}

?>