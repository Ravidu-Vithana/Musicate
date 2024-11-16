<?php

require "connection.php";

$responseObject = new stdClass();
$responseObject->type = "error";
$responseObject->img_status = 0;

if (isset($_POST["v_id"])) {

    $variant_id = $_POST["v_id"];
    $variant = Database::search("SELECT * FROM `variant` WHERE `id` = '".$variant_id."'");
    $variant_data = $variant->fetch_assoc();

    $length = sizeof($_FILES);
    $allowed_img_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
    $variant_img_status = 0;

    if ($length == 1) {
        if (isset($_FILES["vimg"])) {

            $img_file = $_FILES["vimg"];
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

                $file_name = "resources//variant_images//product_id_" . $variant_data["product_id"] . "_" . uniqid() . $new_img_extention;
                move_uploaded_file($img_file["tmp_name"], $file_name);

                Database::iud("UPDATE `variant` SET `image_path` = '".$file_name."' WHERE `id` = '".$variant_id."'");
                $responseObject->type = "success";
            } else {
                $variant_img_status = $variant_img_status + 1;
            }
        }
        $responseObject->img_status = $variant_img_status;
    }
}
$responseJSON = json_encode($responseObject);
echo ($responseJSON);
