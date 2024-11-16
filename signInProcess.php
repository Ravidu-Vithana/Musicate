<?php

session_start();
require "connection.php";

if (isset($_POST["e"]) && isset($_POST["p"])) {

    $email = $_POST["e"];
    $password = $_POST["p"];
    $r = $_POST["r"];

    if (empty($email)) {
        echo ("Please enter your Email");
    } else if (strlen($email) > 100) {
        echo ("Email must have less than 100 characters");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo ("Invalid Email");
    } else if (empty($password)) {
        echo ("Please enter your password");
    } else if (!preg_match("/[A-Z]/",$password) || !preg_match("/[0-9]/",$password) || !preg_match("/[a-z]/",$password) ||!preg_match("/[@#$%&]/",$password)) {
        echo ("Invalid password!");
    } else if (strlen($password) < 5 || strlen($password) > 20) {
        echo ("Password must have between 5 - 20 characters");
    } else {

        $user_rs = Database::search("SELECT * FROM `user` 
        LEFT JOIN `user_blocking_history` ON `user`.`email` = `user_blocking_history`.`user_email` 
        WHERE `email` = '".$email."' AND `password` = '".$password."' ORDER BY `date_time` DESC LIMIT 1;");
        $user_num = $user_rs->num_rows;

        if ($user_num == 1) {

            $user_data = $user_rs->fetch_assoc();

            if($user_data["status"] == 1){

                $_SESSION["user"] = $user_data;

                if ($r == 1) {
                    setcookie("user_email", $email, time() + (60 * 60 * 24 * 365));
                    setcookie("user_password", $password, time() + (60 * 60 * 24 * 365));
                } else {
                    setcookie("user_email", "", -1);
                    setcookie("user_password", "", -1);
                }
    
                echo ("success");

            }else{
                echo ("Your account has been suspended. Reason: '".$user_data["description"]."'");
            }

        } else {
            echo ("Invalid Email or Password");
        }
    }
} else {
    echo ("1");
}
