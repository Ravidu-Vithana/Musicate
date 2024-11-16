<?php

session_start();
require "connection.php";

if(isset($_GET["product_id"])){

    $product_id = $_GET["product_id"];

    $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `product_id` = '$product_id' AND `user_email` = '".$_SESSION["user"]["email"]."'");
    $wishlist_num = $wishlist_rs->num_rows;

    $recent_rs = Database::search("SELECT * FROM `recent` WHERE `product_id` = '$product_id' AND `user_email` = '".$_SESSION["user"]["email"]."'");
    $recent_num = $recent_rs->num_rows;

    if($wishlist_num == 0){

        if($recent_num > 0){
            Database::iud("DELETE FROM `recent` WHERE `user_email` = '".$_SESSION["user"]["email"]."' AND `product_id` = '".$product_id."'");
        }

        Database::iud("INSERT INTO `wishlist`(`user_email`,`product_id`) VALUES ('".$_SESSION["user"]["email"]."','".$product_id."')");
        echo("added");
    }else{
        Database::iud("DELETE FROM `wishlist` WHERE `user_email` = '".$_SESSION["user"]["email"]."' AND `product_id` = '".$product_id."'");
        Database::iud("INSERT INTO `recent`(`user_email`,`product_id`) VALUES ('".$_SESSION["user"]["email"]."','".$product_id."')");
        echo("removed");
    }

}else{
    echo("1");
}

?>