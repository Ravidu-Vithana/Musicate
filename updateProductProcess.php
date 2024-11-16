<?php

session_start();
require "connection.php";

$product_id = $_SESSION["updateProductID"];

//main details start
$title = $_POST["t"];

$v_no = $_POST["v_no"];
$ex_v_no = $_POST["ex_v_no"];

//main details end

//variant details start

$vtitle = array();
$vcon = array();
$vcost = array();
$vdwc = array();
$vdoc = array();
$vdes = array();
$vqty = array();
$vimg_count = array();
$vimg = array();

for ($y = 0; $y < $v_no; $y++) {

    $vtitle[$y] = $_POST["vtitle" . ($y + 1)];
    $vcon[$y] = $_POST["vcon" . ($y + 1)];
    $vcost[$y] = $_POST["vcost" . ($y + 1)];
    $vdwc[$y] = $_POST["vdwc" . ($y + 1)];
    $vdoc[$y] = $_POST["vdoc" . ($y + 1)];
    $vdes[$y] = $_POST["vdes" . ($y + 1)];
    $vqty[$y] = $_POST["vqty" . ($y + 1)];
    $discount[$y] = $_POST["discount" . ($y + 1)];

    if ($y > ($ex_v_no - 1)) {
        $vimg_count[$y] = $_POST["vimg_count" . ($y + 1)];
    }
}

//variant details end

//main validation start

if (empty($title)) {
    echo ("Please insert a title!");
} else {

    //main validation end

    //variant validation start
    for ($z = 0; $z < $v_no; $z++) {

        if (empty($vtitle[$z])) {
            echo ("Please insert a title for variant " . ($z + 1));
            break;
        } else if ($vcon[$z] == 0) {
            echo ("Please select a condition for variant " . ($z + 1));
            break;
        } else if (empty($vcost[$z])) {
            echo ("Please insert the price for variant " . ($z + 1));
            break;
        } else if (!is_numeric($vcost[$z])) {
            echo ("Please enter a valid cost for variant " . ($z + 1));
            break;
        } else if (empty($vdwc[$z])) {
            echo ("Please insert the delivery cost within Colombo for variant " . ($z + 1));
            break;
        } else if (!is_numeric($vdwc[$z])) {
            echo ("Please enter a valid delivery cost within Colombo for variant " . ($z + 1) . $vdwc[$z]);
            break;
        } else if (empty($vdoc[$z])) {
            echo ("Please insert the deivery cost outside Colombo for variant " . ($z + 1));
            break;
        } else if (!is_numeric($vdoc[$z])) {
            echo ("Please enter a valid delivery cost outside Colombo for variant " . ($z + 1));
            break;
        } else if (empty($vdes[$z])) {
            echo ("Please enter the description for the variant " . ($z + 1));
            break;
        } else if (!is_numeric($vqty[$z])) {
            echo ("Please enter a valid quantity for variant " . ($z + 1));
            break;
        } else if ($discount[$z] < 0 || $discount[$z] > 100 || !is_numeric($discount[$z])) {
            echo ("Invalid discount value for variant " . ($z + 1));
            break;
        } else {
            //variant validation end
            //begin the product updating process

            if ($z == ($v_no - 1)) {

                $d = new DateTime();
                $tz = new DateTimeZone("Asia/Colombo");
                $d->setTimezone($tz);
                $date = $d->format("Y-m-d H:i:s");

                Database::iud("UPDATE `product` SET `title` = '$title' WHERE `id` = '$product_id'");

                $variant_id = array();
                $variant = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_id . "' ORDER BY `datetime_added` ASC");

                $ex_price = array();
                $ex_del_fee_colombo = array();
                $ex_del_fee_outside = array();

                for ($b = 0; $b < $ex_v_no; $b++) {
                    $variant_data = $variant->fetch_assoc();
                    $variant_id[$b] = $variant_data["id"];
                    $ex_price[$b] = $variant_data["price"];
                    $ex_del_fee_colombo[$b] = $variant_data["delivery_fee_within_colombo"];
                    $ex_del_fee_outside[$b] = $variant_data["delivery_fee_outside_colombo"];
                }

                for ($a = 0; $a < $v_no; $a++) {

                    if ($a < $ex_v_no) {

                        $updateQuery = "UPDATE `variant` SET `variant_title` = '" . $vtitle[$a] . "',`qty`='" . $vqty[$a] . "',
                        `description`= '" . $vdes[$a] . "',`condition_id`= '" . $vcon[$a] . "',`discount`= '" . $discount[$a] . "'";

                        if ($ex_price[$a] != $vcost[$a]) {
                            $updateQuery .= ",`price`= '" . $vcost[$a] . "'";
                        } else {
                            $vcost[$a] = 0;
                        }

                        if ($ex_del_fee_colombo[$a] != $vdwc[$a]) {
                            $updateQuery .= ",`delivery_fee_within_colombo`= '" . $vdwc[$a] . "'";
                        } else {
                            $vdwc[$a] = 0;
                        }

                        if ($ex_del_fee_outside[$a] != $vdoc[$a]) {
                            $updateQuery .= ",`delivery_fee_outside_colombo`= '" . $vdoc[$a] . "'";
                        } else {
                            $vdoc[$a] = 0;
                        }

                        $updateQuery .= " WHERE `id` = '" . $variant_id[$a] . "'";

                        Database::iud($updateQuery);
                        if ($vcost[$a] != 0 || $vdwc[$a] != 0 || $vdoc[$a] != 0) {
                            Database::iud("INSERT INTO `variant_history` (`new_price`,`del_fee_colombo`,`del_fee_outside`,`datetime_updated`,`variant_id`) 
                            VALUES ('" . $vcost[$a] . "','" . $vdwc[$a] . "','" . $vdoc[$a] . "','" . $date . "','" . $variant_id[$a] . "')");
                        }
                    } else {

                        $vfile_name = "";

                        if (isset($_FILES["vimg" . ($a + 1)])) {

                            $img_file = $_FILES["vimg" . ($a + 1)];
                            $vfile_extension = $img_file["type"];

                            $allowed_img_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

                            if (in_array($vfile_extension, $allowed_img_extentions)) {
                                $new_vimg_extension;

                                if ($vfile_extension == "image/jpg") {
                                    $new_vimg_extension = ".jpg";
                                } else if ($vfile_extension == "image/jpeg") {
                                    $new_vimg_extension = ".jpeg";
                                } else if ($vfile_extension == "image/png") {
                                    $new_vimg_extension = ".png";
                                } else if ($vfile_extension == "image/svg+xml") {
                                    $new_vimg_extension = ".svg";
                                }

                                $vfile_name = "resources//variant_images//product_id_" . $product_id . "_" . uniqid() . $new_vimg_extension;
                                move_uploaded_file($img_file["tmp_name"], $vfile_name);
                            } else {
                                $variant_img_status = $variant_img_status + 1;
                            }
                        }

                        Database::iud("INSERT INTO `variant` (`variant_title`,`price`,`qty`,`description`,`datetime_added`,`delivery_fee_within_colombo`,
                        `delivery_fee_outside_colombo`,`product_id`,`condition_id`,`discount`,`image_path`) 
                        VALUES ('" . $vtitle[$a] . "','" . $vcost[$a] . "','" . $vqty[$a] . "','" . $vdes[$a] . "',
                        '" . $date . "','" . $vdwc[$a] . "','" . $vdoc[$a] . "','" . $product_id . "','" . $vcon[$a] . "','" . $discount[$a] . "','" . $vfile_name . "')");
                    }
                }

                echo ("success");
            }

            //end of product updating process
        }
    }
}
