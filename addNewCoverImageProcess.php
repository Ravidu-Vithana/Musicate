<?php

require "connection.php";

$responseObject = new stdClass();
$responseObject->type = "error";
$responseObject->img_status = 0;

if (isset($_POST["rem"]) && isset($_POST["p_id"])) {

    $remaining = $_POST["rem"];
    $product_id = $_POST["p_id"];

    $length = sizeof($_FILES);
    $allowed_img_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
    $cover_img_status = 0;

    if ($length <= $remaining) {
        for ($x = 0; $x < $length; $x++) {

            if (isset($_FILES["cimg" . $x])) {

                $img_file = $_FILES["cimg" . $x];
                $file_extension = $img_file["type"];

                if (in_array($file_extension, $allowed_img_extentions)) {
                    $new_img_extention;

                    if ($file_extension == "image/jpg") {
                        $new_img_extention = ".jpg";
                    } else if ($file_extension == "image/jpeg") {
                        $new_img_extention = ".jpeg";
                    } else if ($file_extension == "image/png") {
                        $new_img_extention = ".png";
                    } else if ($file_extension == "image/svg+xml") {
                        $new_img_extention = ".svg";
                    }

                    $file_name = "resources//cover_images//product_id_" . $product_id . "_" . uniqid() . $new_img_extention;
                    move_uploaded_file($img_file["tmp_name"], $file_name);

                    Database::iud("INSERT INTO `cover_images`(`path`,`product_id`) VALUES ('" . $file_name . "','" . $product_id . "')");
                    $responseObject->type = "success";
                    
                } else {
                    $cover_img_status = $cover_img_status + 1;
                }
            }
        }
        $responseObject->img_status = $cover_img_status;
    }
}
$responseJSON = json_encode($responseObject);
echo ($responseJSON);
