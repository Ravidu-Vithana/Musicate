<?php

require "connection.php";

if(isset($_GET["img_id"])){

    Database::iud("DELETE FROM `cover_images` WHERE `cover_images_id` = '".$_GET["img_id"]."'");
    echo("deleted");

}else{
    echo("1");
}

?>