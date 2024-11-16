<?php

require "connection.php";

//main details start

$category = $_POST["cat"];
$sub_category = $_POST["subcat"];
$brand = $_POST["b"];
$model = $_POST["m"];
$title = $_POST["t"];

$c_no = $_POST["c_no"];
$v_no = $_POST["v_no"];

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
    $vimg_count[$y] = $_POST["vimg_count" . ($y + 1)];
}

//variant details end

//main validation start

if ($category == 0) {
    echo ("Please select a category!");
} else if ($sub_category == 0) {
    echo ("Please select a sub-category!");
} else if ($brand == 0) {
    echo ("Please select a brand!");
} else if ($model == 0) {
    echo ("Please select a model!");
} else if (empty($title)) {
    echo ("Please insert a title!");
} else if ($c_no == 0) {
    echo ("You have not selected any cover images!");
} else if ($c_no > 5) {
    echo ("Only a maximum of 5 cover photos are allowed!");
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
            echo ("Please enter a valid delivery cost within Colombo for variant " . ($z + 1));
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
        } else if (empty($vqty[$z])) {
            echo ("Please insert the quantity for the variant " . ($z + 1));
            break;
        } else if (!is_numeric($vqty[$z])) {
            echo ("Please enter a valid quantity for variant " . ($z + 1));
            break;
        } else if ($discount[$z] < 0 || $discount[$z] > 100 || !is_numeric($discount[$z])) {
            echo ("Invalid discount value for variant " . ($z + 1));
            break;
        } else if ($vimg_count[$z] == 0) {
            echo ("You have not selected any image for variant " . ($z + 1));
            break;
        } else {
            //variant validation end
            //begin the product adding process

            if ($z == ($v_no - 1)) {

                $obj = new stdClass();

                $brand_has_category_rs = Database::search("SELECT * FROM `brand_has_category` WHERE `brand_id` = '" . $brand . "' 
                AND `category_id` = '" . $category . "' AND `sub_categories_id` = '" . $sub_category . "'");
                $brand_has_category_num = $brand_has_category_rs->num_rows;

                if ($brand_has_category_num == 1) {
                    $brand_has_category_data = $brand_has_category_rs->fetch_assoc();
                    $product_rs = Database::search("SELECT * FROM `product` WHERE `model_id` = '" . $model . "' 
                    AND `brand_has_category_id` = '" . $brand_has_category_data["id"] . "'");
                    $product_num = $product_rs->num_rows;

                    $d = new DateTime();
                    $tz = new DateTimeZone("Asia/Colombo");
                    $d->setTimezone($tz);
                    $date = $d->format("Y-m-d H:i:s");

                    $allowed_img_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

                    $cover_img_status = 0;
                    $variant_img_status = 0;

                    if ($product_num == 0) {

                        $obj->type = "fullproduct";

                        Database::iud("INSERT INTO `product` (`model_id`,`title`,`brand_has_category_id`) 
                        VALUES ('" . $model . "','" . $title . "','" . $brand_has_category_data["id"] . "')");

                        $product_id = Database::$connection->insert_id;

                        for ($c = 0; $c < $c_no; $c++) {

                            if (isset($_FILES["cimg" . $c])) {

                                $img_file = $_FILES["cimg" . $c];
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
                                } else {
                                    $cover_img_status = $cover_img_status + 1;
                                }
                            }
                        }

                        for ($b = 0; $b < $v_no; $b++) {

                            $vfile_name = "";

                            if (isset($_FILES["vimg" . ($b + 1)])) {

                                $img_file = $_FILES["vimg" . ($b + 1)];
                                $vfile_extension = $img_file["type"];

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
                            VALUES ('" . $vtitle[$b] . "','" . $vcost[$b] . "','" . $vqty[$b] . "','" . $vdes[$b] . "',
                            '" . $date . "','" . $vdwc[$b] . "','" . $vdoc[$b] . "','" . $product_id . "','" . $vcon[$b] . "','" . $discount[$b] . "','" . $vfile_name . "')");
                        }
                    } else {

                        $product_data = $product_rs->fetch_assoc();

                        if ($product_data["status"] == 0) {
                            $obj->blocked = "true";
                        } else {
                            $obj->blocked = "false";

                            $obj->type = "variantonly";

                            $vnos = "0";
                            $amt = 0;

                            for ($a = 0; $a < $v_no; $a++) {
                                $variant_rs = Database::search("SELECT * FROM `variant` WHERE `variant_title` = '" . $vtitle[$a] . "' AND `product_id` = '" . $product_data["id"] . "' 
                                AND `condition_id` = '" . $vcon[$a] . "'");
                                $variant_num = $variant_rs->num_rows;

                                if ($variant_num == 0) {

                                    $vfile_name = "";

                                    if (isset($_FILES["vimg" . $a])) {

                                        $img_file = $_FILES["vimg" . $a];
                                        $vfile_extension = $img_file["type"];

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

                                            $vfile_name = "resources//variant_images//product_id_" . $product_data["id"] . "_" . uniqid() . $new_vimg_extension;
                                            move_uploaded_file($img_file["tmp_name"], $vfile_name);
                                        } else {
                                            $variant_img_status = $variant_img_status + 1;
                                        }
                                    }

                                    Database::iud("INSERT INTO `variant` (`variant_title`,`price`,`qty`,`description`,`datetime_added`,`delivery_fee_within_colombo`,
                                `delivery_fee_outside_colombo`,`product_id`,`condition_id`,`discount`,`image_path`) 
                                VALUES ('" . $vtitle[$a] . "','" . $vcost[$a] . "','" . $vqty[$a] . "','" . $vdes[$a] . "',
                                '" . $date . "','" . $vdwc[$a] . "','" . $vdoc[$a] . "','" . $product_data["id"] . "','" . $vcon[$a] . "','" . $discount[$a] . "','" . $vfile_name . "')");

                                    $vnos .= "-" . ($a + 1);
                                    $amt = $amt + 1;
                                }
                            }

                            $obj->vno = $vnos;
                            $obj->vamt = $amt;
                        }
                    }

                    $obj->c_img_status = $cover_img_status;
                    $obj->v_img_status = $variant_img_status;
                } else {
                    $obj->type = "error";
                }

                $json = json_encode($obj);
                echo ($json);
            }

            //end of product adding process
        }
    }
}
