<?php

session_start();
require "connection.php";

if(isset($_GET["product_id"])){

    $product_id = $_GET["product_id"];

    $recent_rs = Database::search("SELECT * FROM `recent` WHERE `product_id` = '$product_id' AND `user_email` = '".$_SESSION["user"]["email"]."'");
    $recent_num = $recent_rs->num_rows;

    if($recent_num > 0){
        Database::iud("DELETE FROM `recent` WHERE `user_email` = '".$_SESSION["user"]["email"]."' AND `product_id` = '".$product_id."'");
        echo("removed");
    }

}else{
    echo("1");
}

?>