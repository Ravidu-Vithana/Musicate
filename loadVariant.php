<?php

require "connection.php";

$obj = new stdClass();

if(isset($_GET["variant_no"]) && isset($_GET["product_id"])){

    $obj->type="ok";

    $product_id = $_GET["product_id"];
    $variant_id = $_GET["variant_no"];

    $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '$product_id' AND `id` = '$variant_id'");
    $variant_data = $variant_rs->fetch_assoc();

    $obj->type="success";
    $obj->data=$variant_data;

}else{
    $obj->type="error";
}

$json = json_encode($obj);
echo($json);

?>