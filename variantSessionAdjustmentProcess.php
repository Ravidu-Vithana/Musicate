<?php

session_start();

if(isset($_SESSION["add"])){

    $new = $_SESSION["add"] - 1;
    $_SESSION["add"] = $new;
    echo("success");

}

?>