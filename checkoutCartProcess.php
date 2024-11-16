<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $email = $_SESSION["user"]["email"];

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    $responseArray = array();
    $orderID = uniqid();
    $responseArray["orderID"] = $orderID;
    $responseArray["datetime"] = $date;

    $user_address = Database::search("SELECT * FROM `user_address` 
        INNER JOIN `city_has_district` ON `city_has_district`.`city_has_district_id` = `user_address`.`city_has_district_id_id` 
        INNER JOIN `district` ON `district`.`district_id` = `city_has_district`.`district_district_id` 
        INNER JOIN `city` ON `city`.`city_id` = `city_has_district`.`city_city_id` 
        WHERE `user_email` = '" . $email . "'");

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
        $responseArray["items"] = $orderID;

        $subTotal = 0;
        $totalDelivery = 0;
        $totalDiscount = 0;

        $cart = Database::search("SELECT * FROM `cart` 
            INNER JOIN `variant` ON `variant`.`id` = `cart`.`variant_id` 
            INNER JOIN `product` ON `product`.`id` = `variant`.`product_id` 
            INNER JOIN `condition` ON `variant`.`condition_id` = `condition`.`id` 
            WHERE `cart`.`user_email` = '" . $email . "'");

        $responseArray["itemCount"] = $cart->num_rows;

        for ($x = 1; $x <= $cart->num_rows; $x++) {
            $cart_data = $cart->fetch_assoc();

            $responseArray["item_id_" . $x] = $cart_data["variant_id"];
            $responseArray["item_name_" . $x] = $cart_data["variant_title"];
            $responseArray["amount_" . $x] = $cart_data["price"];
            $responseArray["quantity_" . $x] = $cart_data["cart_qty"];
            $responseArray["discount_" . $x] = $cart_data["discount"];

            $subTotal = $subTotal + (((int)$cart_data["price"] - ((int)$cart_data["price"] * ((int)$cart_data["discount"] / 100))) * (int)$cart_data["cart_qty"]);
            $totalDiscount = $totalDiscount + ((int)$cart_data["price"] * ((int)$cart_data["discount"] / 100) * (int)$cart_data["cart_qty"]);

            if ($user_address_data["district_name"] == "Colombo") {
                $responseArray["delivery_" . $x] = $cart_data["delivery_fee_within_colombo"];
                $totalDelivery = $totalDelivery + ($cart_data["delivery_fee_within_colombo"] * (int)$cart_data["cart_qty"]);
            } else {
                $responseArray["delivery_" . $x] = $cart_data["delivery_fee_outside_colombo"];
                $totalDelivery = $totalDelivery + ($cart_data["delivery_fee_outside_colombo"] * (int)$cart_data["cart_qty"]);
            }
        }

        $responseArray["totalDiscount"] = $totalDiscount;
        $responseArray["amount"] = $subTotal + $totalDelivery;
        $responseArray["totalDelivery"] = $totalDelivery;

        echo (json_encode($responseArray));
    } else {
        echo ("incompleteProfile");
    }
} else {
    echo ("notSignedIn");
}
