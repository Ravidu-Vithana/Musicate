<?php

require "connection.php";

if (isset($_POST["json"])) {

    $json = $_POST["json"];
    $obj = json_decode($json);

    $title = $obj->title;
    $category = $obj->category;
    $brand = $obj->brand;
    $model = $obj->model;
    $pfrom = $obj->pfrom;
    $pto = $obj->pto;
    $condition = $obj->condition;
    $sort = $obj->sort;

    $query2 = "SELECT * FROM `product`";
    $statusBHC = 0;

    if ($category != 0 || $brand != 0) {

        $statusBHC = 1;
        $query1 = "SELECT * FROM `brand_has_category`";

        if ($category != 0 && $brand == 0) {

            $query1 .= " WHERE `category_id` = '" . $category . "'";
        } else if ($category == 0 && $brand != 0) {

            $query1 .= " WHERE `brand_id` = '" . $brand . "'";
        } else if ($category != 0 && $brand != 0) {

            $query1 .= " WHERE `category_id` = '" . $category . "' AND `brand_id` = '" . $brand . "'";
        }

        $query1 .= ";";

        $brand_has_category_rs = Database::search($query1);
        $brand_has_category_num = $brand_has_category_rs->num_rows;

        if ($brand_has_category_num == 0) {
            $statusBHC = 2;

?>

            <div class="col-12 my-2">
                <div class="row d-flex flex-row justify-content-evenly">
                    <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                    <span class="noresultsText text-center">No Results Found. Try another way.</span>
                </div>
            </div>

        <?php

        } else {

            $status1 = 0;

            for ($x = 0; $x < $brand_has_category_num; $x++) {

                $brand_has_category_data = $brand_has_category_rs->fetch_assoc();

                if ($status1 == 0) {

                    $query2 .= " WHERE `brand_has_category_id` IN ('" . $brand_has_category_data["id"] . "'";
                    $status1 = 1;
                } else {

                    $query2 .= ",'" . $brand_has_category_data["id"] . "'";
                }
            }
        }
    }

    if ($statusBHC != 2) {

        $statusTitle = 0;

        if (!empty($title)) {
            $statusTitle = 1;
            if ($statusBHC == 0) {
                $query2 .= " WHERE `title` LIKE '%" . $title . "%'";
            } else {
                $query2 .= ") AND `title` LIKE '%" . $title . "%'";
            }
        } else {
            if ($statusBHC == 1) {
                $query2 .= ")";
            }
        }

        if ($model != 0) {
            if ($statusBHC == 0 && $statusTitle == 0) {
                $query2 .= " WHERE `model_id` = '" . $model . "'";
            } else {
                $query2 .= " AND `model_id` = '" . $model . "'";
            }
        }

        if ($statusBHC == 1 || $statusTitle == 1) {
            $query2 .= " AND `status` = '1'";
        } else {
            $query2 .= " WHERE `status` = '1'";
        }

        $product_rs = Database::search($query2);
        $product_num = $product_rs->num_rows;

        if ($product_num == 0) {

        ?>

            <div class="col-12 my-2">
                <div class="row d-flex flex-row justify-content-evenly">
                    <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                    <span class="noresultsText text-center">No Results Found. Try another way.</span>
                </div>
            </div>

            <?php

        } else {

            if ($condition != 0 || !empty($pfrom) || !empty($pto) || $sort != 0) {

                $status2 = 0;
                $query3 = "";
                if ($sort == 0) {
                    $query3 = "SELECT DISTINCT `product_id` FROM `variant`";
                } else {
                    if ($sort == 1 || $sort == 2) {
                        $query3 = "SELECT DISTINCT `product_id`, MAX(`price`) FROM `variant`";
                    } else {
                        $query3 = "SELECT DISTINCT `product_id`, MAX(`qty`) FROM `variant`";
                    }
                }

                for ($y = 0; $y < $product_num; $y++) {

                    $product_data = $product_rs->fetch_assoc();

                    if ($status2 == 0) {
                        $query3 .= " WHERE `product_id` IN ('" . $product_data["id"] . "'";
                        $status2 = 1;
                    } else {
                        $query3 .= ",'" . $product_data["id"] . "'";
                    }
                }

                $query3 .= ")";

                if ($condition != 0) {

                    $query3 .= " AND `condition_id` = '" . $condition . "'";
                }

                if (!empty($pfrom) && empty($pto)) {

                    $query3 .= " AND `price` >= '" . $pfrom . "'";
                } else if (empty($pfrom) && !empty($pto)) {

                    $query3 .= " AND `price` <= '" . $pto . "'";
                } else if (!empty($pfrom) && !empty($pto)) {

                    $query3 .= " AND `price` BETWEEN '" . $pfrom . "' AND '" . $pto . "'";
                }

                if ($sort != 0) {
                    if ($sort == 1) {
                        $query3 .= " GROUP BY `product_id` ORDER BY MAX(`price`) ASC,`product_id`;";
                    } else if ($sort == 2) {
                        $query3 .= " GROUP BY `product_id` ORDER BY MAX(`price`) DESC,`product_id`;";
                    } else if ($sort == 3) {
                        $query3 .= " GROUP BY `product_id` ORDER BY MAX(`qty`) ASC,`product_id`;";
                    } else if ($sort == 4) {
                        $query3 .= " GROUP BY `product_id` ORDER BY MAX(`qty`) DESC,`product_id`;";
                    }
                } else {
                    $query3 .= ";";
                }

                $variant_rs = Database::search($query3);
                $variant_num = $variant_rs->num_rows;

                if ($variant_num == 0) {

            ?>

                    <div class="col-12 my-2">
                        <div class="row d-flex flex-row justify-content-evenly">
                            <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                            <span class="noresultsText text-center">No Results Found. Try another way.</span>
                        </div>
                    </div>

                    <?php

                } else {

                    for ($z = 0; $z < $variant_num; $z++) {
                        $variant_data = $variant_rs->fetch_assoc();

                        $product_rs2 = Database::search("SELECT * FROM `product` WHERE `id` = '" . $variant_data["product_id"] . "'");
                        $product_data2 = $product_rs2->fetch_assoc();

                        $cover_img_rs = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '" . $product_data2["id"] . "' ");
                        $cover_img_data = $cover_img_rs->fetch_assoc();

                        $variant_rs2 = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data2["id"] . "' ORDER BY `price` ASC");
                        $variant_data2 = $variant_rs2->fetch_assoc();

                        $min_price = $variant_data2["price"];
                        $max_price = "";

                        $variant_num2 = $variant_rs2->num_rows;

                        if ($variant_num2 > 0) {
                            $variant_rs2 = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data2["id"] . "' ORDER BY `price` DESC");
                            $variant_data2 = $variant_rs2->fetch_assoc();

                            if ($min_price != $variant_data2["price"]) {
                                $max_price = $variant_data2["price"];
                            }
                        }

                        $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data2["id"] . "' ORDER BY `discount` DESC");
                        $variant_data = $variant_rs->fetch_assoc();

                        $max_discount = $variant_data["discount"];
                        $min_discount = "";

                        $variant_num = $variant_rs->num_rows;

                        if ($variant_num > 0 && $max_discount != 0) {

                            $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data2["id"] . "' ORDER BY `discount` ASC");
                            $variant_data = $variant_rs->fetch_assoc();

                            if ($max_discount != $variant_data["discount"]) {
                                $min_discount = $variant_data["discount"];
                            }
                        }

                    ?>


                        <div class="card" style="width: 18rem;">
                            <div class="col-12 d-flex flex-column align-items-center justify-content-center mt-2" style="height: 250px;">
                                <img src="<?php echo ($cover_img_data["path"]); ?>" class="card-img-top cardimg rounded border border-dark border-2 border-opacity-10" alt="..." id="pImg<?php echo ($cover_img_data["cover_images_id"]); ?>" onerror="productImageError('pImg<?php echo ($cover_img_data['cover_images_id']); ?>')">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo ($product_data2["title"]); ?></h5>
                                <?php

                                if ($max_discount != 0) {
                                ?>
                                    <span class="badge rounded-pill text-bg-danger bg-opacity-75 fs-6"><?php if (!empty($min_discount)) {
                                                                                                            echo ($min_discount) ?>&percnt;&nbsp;&hyphen;&nbsp;<?php }
                                                                                                                                                            echo ($max_discount) ?>&percnt; Discounts&excl;</span><br>
                                <?php
                                }

                                ?>

                                <span class="card-text text-primary">Rs. <?php echo ($min_price);

                                                                            if (!empty($max_price)) {
                                                                                echo (" - " . $max_price);
                                                                            }

                                                                            ?></span><br />
                                <button class="col-12 btn btn-outline-success">View</button>
                            </div>
                        </div>

                    <?php

                    }
                }
            } else {

                for ($z = 0; $z < $product_num; $z++) {

                    $product_data = $product_rs->fetch_assoc();

                    $cover_img_rs = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '" . $product_data["id"] . "' ");
                    $cover_img_data = $cover_img_rs->fetch_assoc();

                    $variant_rs2 = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "' ORDER BY `price` ASC");
                    $variant_data2 = $variant_rs2->fetch_assoc();

                    $min_price = $variant_data2["price"];
                    $max_price = "";

                    $variant_num2 = $variant_rs2->num_rows;

                    if ($variant_num2 > 0) {
                        $variant_rs2 = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "' ORDER BY `price` DESC");
                        $variant_data2 = $variant_rs2->fetch_assoc();

                        if ($min_price != $variant_data2["price"]) {
                            $max_price = $variant_data2["price"];
                        }
                    }

                    $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "' ORDER BY `discount` DESC");
                    $variant_data = $variant_rs->fetch_assoc();

                    $max_discount = $variant_data["discount"];
                    $min_discount = "";

                    $variant_num = $variant_rs->num_rows;

                    if ($variant_num > 0 && $max_discount != 0) {

                        $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "' ORDER BY `discount` ASC");
                        for($a = 0; $a < $variant_rs->num_rows; $a++){
                            $variant_data = $variant_rs->fetch_assoc();

                            if ($max_discount != $variant_data["discount"] && $variant_data["discount"] != 0) {
                                $min_discount = $variant_data["discount"];
                                break;
                            }

                        }
                    }

                    ?>


                    <div class="card" style="width: 18rem;">
                        <div class="col-12 d-flex flex-column align-items-center justify-content-center mt-2" style="height: 250px;">
                            <img src="<?php echo ($cover_img_data["path"]); ?>" class="card-img-top cardimg rounded border border-dark border-2 border-opacity-10" alt="..." id="pImg<?php echo ($cover_img_data["cover_images_id"]); ?>" onerror="productImageError('pImg<?php echo ($cover_img_data['cover_images_id']); ?>')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo ($product_data["title"]); ?></h5>
                            <?php

                            if ($max_discount != 0) {
                            ?>
                                <span class="badge rounded-pill text-bg-danger bg-opacity-75 fs-6"><?php if (!empty($min_discount)) {
                                                                                                        echo ($min_discount) ?>&percnt;&nbsp;&hyphen;&nbsp;<?php }
                                                                                                                                                                                    echo ($max_discount) ?>&percnt; Discounts&excl;</span><br>
                            <?php
                            }

                            ?>

                            <span class="card-text text-primary">Rs. <?php echo ($min_price);

                                                                        if (!empty($max_price)) {
                                                                            echo (" - " . $max_price);
                                                                        }

                                                                        ?></span><br />
                            <a class="col-12 btn btn-outline-success stretched-link" href="singleProductView.php?product_id=<?php echo ($product_data["id"]) ?>">View</a>
                        </div>
                    </div>

<?php

                }
            }
        }
    }
} else {
    echo ("1");
}
