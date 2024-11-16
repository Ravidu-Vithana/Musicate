<?php

require "connection.php";

if (isset($_GET["input"]) && isset($_GET["category_id"])) {

    $input = $_GET["input"];
    $category_id = $_GET["category_id"];

    if (empty($input)) {

        echo ("2");
    } else if (!empty($input) && $category_id != 0) {

        $brand_has_category_rs = Database::search("SELECT * FROM `brand_has_category` WHERE `category_id` = '" . $category_id . "'");
        $brand_has_category_num = $brand_has_category_rs->num_rows;

?>
        <div class="row gap-3 mainViewDiv">
            <div class="col-12 bg-dark bg-opacity-10 searchResultsForDiv">
                <span class="noresultsText text-center">Search Results For "<?php echo ($input); ?>"</span>
            </div>

            <?php

            if ($brand_has_category_num == 0) {

            ?>

                <div class="col-12 my-2">
                    <div class="row d-flex flex-row justify-content-evenly">
                        <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                        <span class="noresultsText text-center">No Results Found. Try another way.</span>
                    </div>
                </div>

                <?php

            } else {

                $status = 0;
                $query = "SELECT * FROM `product` WHERE `title` LIKE '%" . $input . "%' AND `status` = '1' AND `brand_has_category_id` IN (";

                for ($x = 0; $x < $brand_has_category_num; $x++) {

                    $brand_has_category_data = $brand_has_category_rs->fetch_assoc();

                    if ($status == 0) {

                        $query .= "'" . $brand_has_category_data["id"] . "'";
                        $status = 1;
                    } else {

                        $query .= ",'" . $brand_has_category_data["id"] . "'";
                    }
                }

                $query .= ");";

                $product_rs = Database::search($query);
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

                    for ($y = 0; $y < $product_num; $y++) {

                        $product_data = $product_rs->fetch_assoc();

                        $cover_img_rs = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '" . $product_data["id"] . "' ");
                        $cover_img_data = $cover_img_rs->fetch_assoc();

                        $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "' ORDER BY `price` ASC");
                        $variant_data = $variant_rs->fetch_assoc();

                        $min_price = $variant_data["price"];
                        $max_price = "";

                        $variant_num = $variant_rs->num_rows;

                        if ($variant_num > 0) {
                            $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "' ORDER BY `price` DESC");
                            $variant_data = $variant_rs->fetch_assoc();

                            if ($min_price != $variant_data["price"]) {
                                $max_price = $variant_data["price"];
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

            ?>

        </div>

    <?php
    } else if (!empty($input) && $category_id == 0) {

        $product_rs = Database::search("SELECT * FROM `product` WHERE `title` LIKE '%" . $input . "%' AND `status` = '1'");
        $product_num = $product_rs->num_rows;

    ?>
        <div class="row gap-3 mainViewDiv">
            <div class="col-12 bg-dark bg-opacity-10 searchResultsForDiv">
                <span class="noresultsText text-center">Search Results For "<?php echo ($input); ?>"</span>
            </div>

            <?php

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

                for ($y = 0; $y < $product_num; $y++) {

                    $product_data = $product_rs->fetch_assoc();

                    $cover_img_rs = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '" . $product_data["id"] . "' ");
                    $cover_img_data = $cover_img_rs->fetch_assoc();

                    $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "' ORDER BY `price` ASC");
                    $variant_data = $variant_rs->fetch_assoc();

                    $min_price = $variant_data["price"];
                    $max_price = "";

                    $variant_num = $variant_rs->num_rows;

                    if ($variant_num > 0) {
                        $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "' ORDER BY `price` DESC");
                        $variant_data = $variant_rs->fetch_assoc();

                        if ($min_price != $variant_data["price"]) {
                            $max_price = $variant_data["price"];
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

            ?>

        </div>

<?php

    }
} else {
    echo ("1");
}
