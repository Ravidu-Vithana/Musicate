<?php

session_start();

if(isset($_SESSION["add"])){

    $variant_no = $_SESSION["add"];
    echo($variant_no);

}else{
    echo("nosession");
}

?>