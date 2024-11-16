<?php

session_start();
require "connection.php";

if (isset($_POST["selectedQty"]) && isset($_POST["selectedVariant"])) {

    $selectedQty = $_POST["selectedQty"];
    $selectedVariant = $_POST["selectedVariant"];

    if (isset($_SESSION["user"])) {

        $email = $_SESSION["user"]["email"];

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        $responseArray;
        $responseArray["orderID"] = uniqid();
        $responseArray["datetime"] = $date;

        $user_address = Database::search("SELECT * FROM `user_address` 
        INNER JOIN `city_has_district` ON `city_has_district`.`city_has_district_id` = `user_address`.`city_has_district_id_id` 
        INNER JOIN `district` ON `district`.`district_id` = `city_has_district`.`district_district_id` 
        INNER JOIN `city` ON `city`.`city_id` = `city_has_district`.`city_city_id` 
        WHERE `user_email` = '" . $email . "'");

        if ($user_address->num_rows == 1) {

            $user_address_data = $user_address->fetch_assoc();

            $variant = Database::search("SELECT * FROM `variant` INNER JOIN `product` ON `product`.`id`=`variant`.`product_id` WHERE `variant`.`id` = '" . $selectedVariant . "'");
            $variant_data = $variant->fetch_assoc();

            if ($variant_data["status"] == 0) {
                echo ("notAvailable");
            } else {
                $delivery = "0";

                if ($user_address_data["district_name"] == "Colombo") {
                    $responseArray["delivery_1"] = $variant_data["delivery_fee_within_colombo"];
                    $delivery = (int)$variant_data["delivery_fee_within_colombo"] * (int)$selectedQty;
                } else {
                    $responseArray["delivery_1"] = $variant_data["delivery_fee_outside_colombo"];
                    $delivery = (int)$variant_data["delivery_fee_outside_colombo"] * (int)$selectedQty;
                }

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
                $responseArray["items"] = $variant_data["variant_title"];
                $responseArray["item_id_1"] = $selectedVariant;
                $responseArray["item_name_1"] = $variant_data["variant_title"];
                $responseArray["amount_1"] = $variant_data["price"];
                $responseArray["quantity_1"] = $selectedQty;
                $responseArray["discount_1"] = $variant_data["discount"];
                $responseArray["amount"] = (((int)$variant_data["price"] - ((int)$variant_data["price"] * ((int)$variant_data["discount"] / 100))) * (int)$selectedQty) + (int)$delivery;
                $responseArray["totalDiscount"] = (int)$variant_data["price"] * ((int)$variant_data["discount"] / 100) * (int)$selectedQty;
                $responseArray["totalDelivery"] = $delivery;

                echo (json_encode($responseArray));
            }
        } else {
            echo ("incompleteProfile");
        }
    } else {
        echo ("notSignedIn");
    }
} else {
    echo ("1");
}
