<?php

session_start();
require "connection.php";

if (isset($_POST["orderObject"]) && isset($_POST["isCart"])) {

    $orderObject = json_decode($_POST["orderObject"], true);
    $isCart;
    if ($_POST["isCart"] == "true") {
        $isCart = true;
    } else {
        $isCart = false;
    }

    Database::iud("INSERT INTO `invoice` VALUES ('" . $orderObject["orderID"] . "','" . $orderObject["email"] . "','" . $orderObject["datetime"] . "')");

    if ($isCart) {
        for ($c = 1; $c <= $orderObject["itemCount"]; $c++) {
            Database::iud("UPDATE `variant` SET `qty` = `qty` - '" . $orderObject["quantity_" . $c] . "' WHERE `id` = '" . $orderObject["item_id_" . $c] . "' AND `qty` >= '" . $orderObject["quantity_" . $c] . "'");
            Database::iud("INSERT INTO `items` (`invoice_id`,`variant_id`,`inv_qty`,`buying_price`,`discount_given`,`buying_del_free`) 
            VALUES ('" . $orderObject["orderID"] . "', '" . $orderObject["item_id_" . $c] . "', '" . $orderObject["quantity_" . $c] . "', '" . $orderObject["amount_" . $c] . "', '" . $orderObject["discount_" . $c] . "', '" . $orderObject["delivery_" . $c] . "')");
        }
        Database::iud("DELETE FROM `cart` WHERE `user_email` = '" . $_SESSION["user"]["email"] . "'");
    } else {
        Database::iud("UPDATE `variant` SET `qty` = `qty` - '" . $orderObject["quantity_1"] . "' WHERE `id` = '" . $orderObject["item_id_1"] . "' AND `qty` >= '" . $orderObject["quantity_1"] . "'");
        Database::iud("INSERT INTO `items` (`invoice_id`,`variant_id`,`inv_qty`,`buying_price`,`discount_given`,`buying_del_free`) 
            VALUES ('" . $orderObject["orderID"] . "', '" . $orderObject["item_id_1"] . "', '" . $orderObject["quantity_1"] . "', '" . $orderObject["amount_1"] . "', '" . $orderObject["discount_1"] . "', '" . $orderObject["delivery_1"] . "')");
    }

    echo("success");

} else {
    echo ("1");
}
