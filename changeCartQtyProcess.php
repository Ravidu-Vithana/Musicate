<?php

session_start();
require "connection.php";

if(isset($_POST["change"]) && isset($_POST["selectedQty"]) && isset($_POST["variant_id"])){

    $variant_id = $_POST["variant_id"];
    $selectedQty = $_POST["selectedQty"];
    $change = $_POST["change"];
    $newQty = intval($selectedQty) + intval($change);

    $variant = Database::search("SELECT * FROM `variant` WHERE `id` = '$variant_id'");
    $variantData = $variant->fetch_assoc();

    if($newQty > 0){
        if($newQty > $variantData["qty"]){
            echo("qtyerror");
        }else{
            Database::iud("UPDATE `cart` SET `cart_qty` = '$newQty' WHERE `user_email` = '".$_SESSION["user"]["email"]."' AND `variant_id` = '$variant_id'");
            echo($newQty);
        }
    }else{
        echo("minqty");
    }

}else{
    echo("error");
}

?>