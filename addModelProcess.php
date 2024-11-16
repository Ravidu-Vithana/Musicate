<?php

require "connection.php";

if(isset($_GET["m"]) && isset($_GET["b"])){
    $m_name = $_GET["m"];
    $bid = $_GET["b"];

    $model_rs = Database::search("SELECT * FROM `model` WHERE `model_name` = '".$m_name."' AND `brand_id` = '".$bid."'");
    $model_num = $model_rs->num_rows;

    if($model_num == 0){
        Database::iud("INSERT INTO `model`(`model_name`,`brand_id`) VALUES('".$m_name."','".$bid."')");
        echo("success");
    }else{
        echo("2");
    }

}else{
    echo("1");
}

?>