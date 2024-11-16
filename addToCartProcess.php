<?php

session_start();
require "connection.php";

if (isset($_POST["selectedQty"]) && isset($_POST["selectedVariant"])) {

    $selectedQty = $_POST["selectedQty"];
    $selectedVariant = $_POST["selectedVariant"];
    $email = $_SESSION["user"]["email"];

    $cart = Database::search("SELECT * FROM `cart` WHERE `variant_id` = '$selectedVariant' AND `user_email` = '$email'");

    $variant = Database::search("SELECT * FROM `variant` WHERE `id` = '$selectedVariant'");
    $variantData = $variant->fetch_assoc();

    if ($cart->num_rows == 0) {

        if ($selectedQty <= $variantData["qty"]) {
            Database::iud("INSERT INTO `cart` (`cart_qty`,`user_email`,`variant_id`) VALUES ('$selectedQty','$email','$selectedVariant')");
            echo ("success");
        } else {
            echo ("Maximum available quantity exceeded!");
        }
    } else {

        $cartData = $cart->fetch_assoc();
        $newQty = $selectedQty + $cartData["cart_qty"];

        if ($newQty <= $variantData["qty"]) {
            Database::iud("UPDATE `cart` SET `cart_qty` = '$newQty' WHERE `user_email` = '$email' AND `variant_id` = '$selectedVariant'");
            echo ("success");
        } else {
            echo ("Maximum available quantity exceeded!");
        }
    }
} else {
    echo ("1");
}
