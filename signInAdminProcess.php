<?php

session_start();
require "connection.php";

$obj2 = new stdClass();
$obj2->type = "error";

if (isset($_POST["json"])) {

    $obj2->msg = "process";

    $json = $_POST["json"];
    $obj = json_decode($json);

    $email = $obj->email;
    $password = $obj->password;
    $r = $obj->rememberMe;

    if (empty($email)) {
        $obj2->msg = "Please enter your Email";
    } else if (strlen($email) > 100) {
        $obj2->msg = "Email must have less than 100 characters";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $obj2->msg = "Invalid Email";
    } else if (empty($password)) {
        $obj2->msg = "Please enter your password";
    } else if (!preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[@#$%&]/", $password)) {
        echo ("Invalid password!");
    } else if (strlen($password) < 5 || strlen($password) > 20) {
        $obj2->msg = "Password must have between 5 - 20 characters";
    } else {

        $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email` = '" . $email . "' 
        AND `password` = '" . $password . "'");
        $admin_num = $admin_rs->num_rows;

        if ($admin_num == 1) {

            $admin_data = $admin_rs->fetch_assoc();
            $_SESSION["admin"] = $admin_data;

            if ($r == 1) {
                setcookie("admin_email", $email, time() + (60 * 60 * 24 * 365));
                setcookie("admin_password", $password, time() + (60 * 60 * 24 * 365));
            } else {
                setcookie("admin_email", "", -1);
                setcookie("admin_password", "", -1);
            }

            $obj2->type = "success";
        } else {
            $obj2->msg = "Invalid Email or Password";
        }
    }
} else {
    $obj2->msg = "1";


}

$json2 = json_encode($obj2);
echo($json2);