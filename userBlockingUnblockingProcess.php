<?php

session_start();
require "connection.php";

if (isset($_GET["email"]) && isset($_GET["status"])) {

    $email = $_GET["email"];
    $userStatus = $_GET["status"];
    $adminEmail = $_SESSION["admin"]["email"];

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if ($userStatus == "active") {

        if (isset($_GET["reason"])) {

            $reason = $_GET["reason"];

            if (empty($reason)) {
                echo ("Please enter the reason for blocking this user.");
            } else {
                $user = Database::search("SELECT * FROM `user` WHERE `email` = '$email'");
                if ($user->num_rows == 1) {

                    Database::iud("INSERT INTO `user_blocking_history`(`description`,`user_email`,`admin_email`,`date_time`) VALUES('$reason','$email','$adminEmail','$date');");

                    Database::iud("UPDATE `user` SET `status` = '0' WHERE `email` = '$email'");
                    echo ("blocked");
                } else {
                    echo ("1");
                }
            }
        } else {
            echo ("1");
        }
    } else {

        $user = Database::search("SELECT * FROM `user` WHERE `email` = '$email'");
        if ($user->num_rows == 1) {

            Database::iud("UPDATE `user` SET `status` = '1' WHERE `email` = '$email'");
            echo ("active");
        } else {
            echo ("1");
        }
    }
} else {
    echo ("1");
}
