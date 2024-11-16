<?php
session_start();
require "connection.php";

$responseObject = new stdClass();
$responseObject->type = "error";

if (isset($_SESSION["updateProductID"])) {

    $product_id = $_SESSION["updateProductID"];

    $variant = Database::search("SELECT * FROM `variant` WHERE `product_id` = '$product_id'");
    $variant_num = $variant->num_rows;

    $responseObject->type = "success";
    $responseObject->msg = $variant_num;
    
}

$responseJSON = json_encode($responseObject);
echo($responseJSON);