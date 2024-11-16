<?php

require "connection.php";

if(isset($_GET["variant_id"])){
    
    $variant_id = $_GET["variant_id"];

    Database::iud("DELETE FROM `variant` WHERE `id` = '".$variant_id."'");
    echo("success");

}else{
    echo("1");
}

?>