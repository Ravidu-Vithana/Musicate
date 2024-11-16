<?php 

require "connection.php";

if(isset($_GET["subc"]) && isset($_GET["cat"])){
    $sc_name = $_GET["subc"];
    $cid = $_GET["cat"];

    $subcat_rs = Database::search("SELECT * FROM `sub_categories` WHERE `sub_name` LIKE '%".$sc_name."%' AND `category_id` = '".$cid."'");
    $subcat_num = $subcat_rs->num_rows;

    if($subcat_num == 0){
        Database::iud("INSERT INTO `sub_categories`(`sub_name`,`category_id`) VALUES('".$sc_name."','".$cid."')");
        echo("success");
    }else{
        echo("2");
    }
}else{
    echo("1");
}

?>