<?php

require "connection.php";

if(isset($_GET["cart_id"])){

    $cart_id = $_GET["cart_id"];

    Database::iud("DELETE FROM `cart` WHERE `cart_id` = '$cart_id'");
    echo("success");

}else{
    echo('1');
}

?>