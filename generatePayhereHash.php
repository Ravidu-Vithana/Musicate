<?php

if(isset($_GET["order_id"])&&isset($_GET["amount"])){

    $hash = strtoupper(
        md5(
            "1221370" . 
            $_GET["order_id"] . 
            number_format($_GET["amount"], 2, '.', '') . 
            "LKR" .  
            strtoupper(md5("MTA3OTY5OTQ3MjkzODY1NjIwMzM2NTk4OTQ5NjQ3MjkzMDkyMg")) 
        ) 
    );

    echo($hash);

}else{
    echo("1");
}