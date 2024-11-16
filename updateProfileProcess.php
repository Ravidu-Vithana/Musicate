<?php

session_start();
require "connection.php";

$obj = new stdClass();
$obj->type = "error";

if(isset($_POST["json"])){

    $json = $_POST["json"];

    $obj2 = json_decode($json);

    $fname = $obj2->fname;
    $lname = $obj2->lname;
    $mobile = $obj2->mobile;
    $password = $obj2->password;
    $gender = $obj2->gender;
    $line1 = $obj2->line1;
    $line2 = $obj2->line2;
    $province = $obj2->province;
    $district = $obj2->district;
    $city = $obj2->city;
    $postal = $obj2->postal;

    $old_passwords = Database::search("SELECT * FROM `old_passwords` WHERE `user_email` = '".$_SESSION["user"]["email"]."' AND `old_password` = '".$password."'");
    $old_passwords_num = $old_passwords->num_rows;

    if(empty($fname)){
        $obj->errormsg = "First Name cannot be empty";
    }else if(strlen($fname) > 20){
        $obj->errormsg = "First Name cannot exceed more than 20 Characters";
    }else if(empty($lname)){
        $obj->errormsg = "Last Name cannot be empty";
    }else if(strlen($lname) > 30){
        $obj->errormsg = "Last Name cannot exceed more than 30 Characters";
    }else if(empty($mobile)){
        $obj->errormsg = "Mobile cannot be empty";
    }else if (!preg_match("/07[01245678][0-9]/",$mobile)){
        $obj->errormsg = "Invalid Mobile Number!";
    }else if (strlen($mobile) != 10){
        $obj->errormsg = "Mobile number should contain 10 Characters!";
    }else if(empty($password)){
        $obj->errormsg = "Password cannot be empty";
    }else if(strlen($password) > 20 OR strlen($password) < 5){
        $obj->errormsg = "Password must contain 5 - 20 characters!";
    }else if($old_passwords_num != 0){
        $obj->errormsg = "Please use a new password that haven't been used before.";
    } else{

        $obj->type = "updating";
        $obj->imagestatus = "no";

        if (isset($_FILES["image"])) {

            $obj->imagestatus = "notupdated";
            $image = $_FILES["image"];
    
            $allowed_ex = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
            $file_ex = $image["type"];
    
            if (!in_array($file_ex, $allowed_ex)) {
                $obj->imagestatus = "notvalid";
            } else {
    
                $new_file_ex;
    
                if ($file_ex == "image/jpg") {
                    $new_file_ex = ".jpg";
                } else if ($file_ex == "image/jpeg") {
                    $new_file_ex = ".jpeg";
                } else if ($file_ex == "image/png") {
                    $new_file_ex = ".png";
                } else if ($file_ex == "image/svg+xml") {
                    $new_file_ex = ".svg";
                }
    
                $file_name = "resources//profile_images//" . $_SESSION["user"]["fname"] . "_" . uniqid() . $new_file_ex;
    
                move_uploaded_file($image["tmp_name"], $file_name);
    
                $image_rs = Database::search("SELECT * FROM `profile_images` WHERE `user_email` = '" . $_SESSION["user"]["email"] . "'");
    
                $image_num = $image_rs->num_rows;
    
                if ($image_num == 1) {
                    Database::iud("UPDATE `profile_images` SET `path`='" . $file_name . "' WHERE `user_email`='" . $_SESSION["user"]["email"] . "' ");
                    $obj->imagestatus = "ok";
                } else {
                    Database::iud("INSERT INTO `profile_images`(`path`,`user_email`) VALUES ('" . $file_name . "','" . $_SESSION["user"]["email"] . "')");
                    $obj->imagestatus = "ok";
                }
            }
        }

        $obj->addressstatus = "no";

        if($province != 0 && $district != 0 && $city != 0 && !empty($line1)){

            $city_has_district_rs = Database::search("SELECT * FROM `city_has_district` WHERE `city_city_id` = '".$city."' AND `district_district_id` = '".$district."'");
            $city_has_district_num = $city_has_district_rs->num_rows;

            if($city_has_district_num == 0){
                Database::iud("INSERT INTO `city_has_district` (`city_city_id`,`district_district_id`) 
                VALUES ('".$city."','".$district."')");

                $city_has_district_rs = Database::search("SELECT * FROM `city_has_district` WHERE `city_city_id` = '".$city."' AND `district_district_id` = '".$district."'");
                $city_has_district_data = $city_has_district_rs->fetch_assoc();

            }else{
                $city_has_district_data = $city_has_district_rs->fetch_assoc();
            }

            $user_address_rs = Database::search("SELECT * FROM `user_address` WHERE `user_email` = '".$_SESSION["user"]["email"]."'");
            $user_address_num = $user_address_rs->num_rows;

            if($user_address_num == 0){
                Database::iud("INSERT INTO `user_address` (`user_email`,`line1`,`line2`,`postal_code`,`city_has_district_id_id`) 
                VALUES ('".$_SESSION["user"]["email"]."','".$line1."','".$line2."','".$postal."','".$city_has_district_data["city_has_district_id"]."')");
                $obj->addressstatus = "ok";
            }else{
                Database::iud("UPDATE `user_address` SET `line1`='" . $line1 . "',`line2`='" . $line2 . "',`city_has_district_id_id`='" . $city_has_district_data["city_has_district_id"] . "',`postal_code`='" . $postal . "'
                WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
                $obj->addressstatus = "ok";
            }

        }

        $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '".$_SESSION["user"]["email"]."'");
        $user_data = $user_rs->fetch_assoc();

        if($password != $user_data["password"]){
            Database::iud("INSERT INTO `old_passwords` (`old_password`,`user_email`) 
            VALUES ('".$user_data["password"]."','".$user_data["email"]."')");
        }

        Database::iud("UPDATE `user` SET `fname` = '".$fname."',`lname` = '".$lname."',`mobile` = '".$mobile."',`password` = '".$password."',`gender_id` = '".$gender."' 
        WHERE `email` = '".$user_data["email"]."'");

        $obj->type = "ok";

    }

}else {
    $obj->errormsg = "1";
}

$json2 = json_encode($obj);
echo($json2);

?>