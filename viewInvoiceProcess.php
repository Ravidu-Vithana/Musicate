<?php

session_start();
require "connection.php";

if (isset($_GET["order_id"]) && isset($_GET["date"])) {

    $email = $_SESSION["user"]["email"];

    $invoice =  Database::search("SELECT * FROM `invoice` 
    INNER JOIN `items` ON `items`.`invoice_id` = `invoice`.`inv_id` 
    INNER JOIN `variant` ON `variant`.`id` = `items`.`variant_id` 
    INNER JOIN `product` ON `product`.`id` = `variant`.`product_id` 
    INNER JOIN `condition` ON `variant`.`condition_id` = `condition`.`id` 
    WHERE `inv_id` = '" . $_GET["order_id"] . "'");

    $user_address = Database::search("SELECT * FROM `user_address` 
    INNER JOIN `city_has_district` ON `city_has_district`.`city_has_district_id` = `user_address`.`city_has_district_id_id` 
    INNER JOIN `district` ON `district`.`district_id` = `city_has_district`.`district_district_id` 
    INNER JOIN `city` ON `city`.`city_id` = `city_has_district`.`city_city_id` 
    WHERE `user_email` = '" . $email . "'");









    $responseArray = array();
    $responseArray["orderID"] = $_GET["order_id"];
    $responseArray["datetime"] = $_GET["date"];

    if ($user_address->num_rows == 1) {

        $user_address_data = $user_address->fetch_assoc();

        $address = $user_address_data["line1"];

        if (!empty($user_address_data["line2"])) {
            $address .= "," . $user_address_data["line2"];
        }

        $responseArray["firstname"] = $_SESSION["user"]["fname"];
        $responseArray["lastname"] = $_SESSION["user"]["lname"];
        $responseArray["mobile"] = $_SESSION["user"]["mobile"];
        $responseArray["city"] = $user_address_data["city_name"];
        $responseArray["email"] = $email;
        $responseArray["address"] = $address;
        $responseArray["items"] = $_GET["order_id"];

        $subTotal = 0;
        $totalDelivery = 0;
        $totalDiscount = 0;

        $responseArray["itemCount"] = $invoice->num_rows;

        for ($x = 1; $x <= $invoice->num_rows; $x++) {
            $invoiceData = $invoice->fetch_assoc();

            $responseArray["item_id_" . $x] = $invoiceData["variant_id"];
            $responseArray["item_name_" . $x] = $invoiceData["variant_title"];
            $responseArray["amount_" . $x] = $invoiceData["buying_price"];
            $responseArray["quantity_" . $x] = $invoiceData["inv_qty"];
            $responseArray["discount_" . $x] = $invoiceData["discount_given"];

            $subTotal = $subTotal + (((int)$invoiceData["buying_price"] - ((int)$invoiceData["buying_price"] * ((int)$invoiceData["discount_given"] / 100))) * (int)$invoiceData["inv_qty"]);
            $totalDiscount = $totalDiscount + ((int)$invoiceData["buying_price"] * ((int)$invoiceData["discount_given"] / 100) * (int)$invoiceData["inv_qty"]);
            $responseArray["delivery_" . $x] = $invoiceData["buying_del_fee"];
        }

        $responseArray["totalDiscount"] = $totalDiscount;
        $responseArray["amount"] = $subTotal + $totalDelivery;
        $responseArray["totalDelivery"] = $totalDelivery;

        echo (json_encode($responseArray));
    } else {
        echo ("incompleteProfile");
    }
}else{
    echo("1");
}
