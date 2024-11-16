<?php

require "connection.php";


$vcode = $_POST["vcode"];
$npw = $_POST["npw"];
$rnpw = $_POST["rnpw"];

if (isset($_POST["email"]) || empty($_POST["email"]) || isset($_POST["acc_type"])) {

    $email = $_POST["email"];
    $acc_type = $_POST["acc_type"];

    if (empty($vcode)) {
        echo ("Please enter the verification code.");
    } else if (empty($npw)) {
        echo ("Please type the new password.");
    } else if (strlen($npw) < 5 or strlen($npw) > 20) {
        echo ("Password should contain 5 - 20 characters.");
    } else if (!preg_match("/[A-Z]/", $npw) || !preg_match("/[0-9]/", $npw) || !preg_match("/[a-z]/", $npw) || !preg_match("/[@#$%&]/", $npw)) {
        echo ("Invalid password!");
    } else if (empty($rnpw)) {
        echo ("Please re-type the new password.");
    } else if ($npw != $rnpw) {
        echo ("Passwords does not match!");
    } else {

        if ($acc_type == "user") {
            $oldpw_rs = Database::search("SELECT * FROM `old_passwords` WHERE `user_email` = '" . $email . "' AND `old_password` = '$npw'");
            $oldpw_num = $oldpw_rs->num_rows;
        } else {
            $oldpw_rs = Database::search("SELECT * FROM `old_passwords_admin` WHERE `admin_email` = '" . $email . "' AND `old_password` = '$npw'");
            $oldpw_num = $oldpw_rs->num_rows;
        }

        if ($oldpw_num != 0) {
            echo ("This password has already been used.");
        } else {

            if ($acc_type == "user") {
                $result_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "' 
                AND `verification_code` = '" . $vcode . "'");
                $result_num = $result_rs->num_rows;
            } else {
                $result_rs = Database::search("SELECT * FROM `admin` WHERE `email` = '" . $email . "' 
                AND `verification_code` = '" . $vcode . "'");
                $result_num = $result_rs->num_rows;
            }

            if ($result_num == 1) {

                $result_data = $result_rs->fetch_assoc();

                if ($result_data["password"] == $npw) {
                    echo ("This password has already been used.");
                } else {

                    if ($acc_type == "user") {
                        Database::iud("INSERT INTO `old_passwords`(`old_password`,`user_email`) 
                        VALUES('" . $result_data["password"] . "','" . $email . "')");

                        Database::iud("UPDATE `user` SET `password` = '" . $npw . "' WHERE `email` = '" . $email . "'");
                        echo ("success");
                    } else {
                        Database::iud("INSERT INTO `old_passwords_admin`(`old_password`,`admin_email`) 
                        VALUES('" . $result_data["password"] . "','" . $email . "')");

                        Database::iud("UPDATE `admin` SET `password` = '" . $npw . "' WHERE `email` = '" . $email . "'");
                        echo ("success");
                    }
                }
            } else {
                echo ("Invalid Veriication Code.");
            }
        }
    }
} else {
    echo ("Something went wrong. Please try again.");
}
