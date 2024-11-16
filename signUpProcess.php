<?php

require "connection.php";

$fname = $_POST["f"];
$lname = $_POST["l"];
$dob = $_POST["dob"];
$gender = $_POST["g"];
$email = $_POST["e"];
$password = $_POST["p"];
$mobile = $_POST["m"];
$agreed = $_POST["a"];

if (empty($fname)) {
    echo ("emptyf");
} else if (strlen($fname) > 20) {
    echo ("longf");
} else if (empty($lname)) {
    echo ("emptyl");
} else if (strlen($lname) > 30) {
    echo ("longl");
} else if (empty($dob)) {
    echo ("emptydob");
} else if ($gender == 0) {
    echo ("notselectedg");
} else if (empty($email)) {
    echo ("emptye");
} else if (strlen($email) > 100) {
    echo ("longe");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("invalide");
} else if (empty($password)) {
    echo ("emptyp");
} else if (!preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[@#$%&]/", $password)) {
    echo ("Invalid password!");
} else if (strlen($password) > 20 or strlen($password) < 5) {
    echo ("strlenp");
} else if (empty($mobile)) {
    echo ("emptym");
} else if (!preg_match("/^\+947[1245678]\d{7}$/", $mobile)) {
    echo ("invalidm");
} else if ($agreed == 0) {
    echo ("notaccepted");
} else {

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "' 
    OR `mobile` = '" . $mobile . "'");
    $user_num = $user_rs->num_rows;

    if ($user_num == 1) {
        echo ("userexist");
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user` (`email`,`fname`,`lname`,`mobile`,`dob`,`password`,`joined_date`,`status`,`gender_id`) 
        VALUES ('" . $email . "','" . $fname . "','" . $lname . "','" . $mobile . "','" . $dob . "','" . $password . "','" . $date . "','1','" . $gender . "')");

        echo ("success");
    }
}
