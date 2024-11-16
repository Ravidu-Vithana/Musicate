<?php

require "connection.php";

if (isset($_GET["price"]) && isset($_GET["category_id"])) {

    $price = $_GET["price"];
    $categories = $_GET["category_id"];
    $brandHasCategory = true;

    $mainQuery = "SELECT * FROM `product` INNER JOIN `variant` ON `product`.`id` = `variant`.`product_id`";

    if ($categories != 0) {

        $category = explode(",", $categories);
        $category_amt = sizeof($category);

        $status = 0;

        $query1 = "SELECT * FROM `brand_has_category`";

        for ($x = 1; $x < $category_amt; $x++) {

            if ($status == 0) {
                $query1 .= " WHERE `category_id` IN ('" . $category[$x] . "'";
                $status = 1;
            } else {
                $query1 .= ",'" . $category[$x] . "'";
            }
        }

        $query1 .= ");";

        $brand_has_category_rs = Database::search($query1);
        $brand_has_category_num = $brand_has_category_rs->num_rows;
        if ($brand_has_category_num == 0) {
            $brandHasCategory = false;

?>

            <div class="col-12">
                <div class="row d-flex flex-row justify-content-evenly">
                    <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 500px;">
                    <span class="noresultsText text-center">No Results Found. Try another way.</span>
                </div>
            </div>

        <?php

        } else {

            $status2 = 0;

            for ($y = 0; $y < $brand_has_category_num; $y++) {

                $brand_has_category_data = $brand_has_category_rs->fetch_assoc();

                if ($status2 == 0) {
                    $mainQuery .= " WHERE `brand_has_category_id` IN ('" . $brand_has_category_data["id"] . "'";
                    $status2 = 1;
                } else {
                    $mainQuery .= ",'" . $brand_has_category_data["id"] . "'";
                }
            }

            $mainQuery .= ")";
        }
    }

    if ($brandHasCategory) {
        if (str_contains($mainQuery, 'WHERE')) {
            $mainQuery .= " AND `status` = '1'";
        } else {
            $mainQuery .= " WHERE `status` = '1'";
        }

        if ($price == 0) {
            $mainQuery .= ";";
        } else if ($price == 1) {
            $mainQuery .= " AND `price` <= '50000';";
        } else if ($price == 2) {
            $mainQuery .= " AND `price` BETWEEN '50000' AND '100000';";
        } else if ($price == 3) {
            $mainQuery .= " AND `price` BETWEEN '100000' AND '150000';";
        } else if ($price == 4) {
            $mainQuery .= " AND `price` BETWEEN '150000' AND '200000';";
        } else if ($price == 5) {
            $mainQuery .= " AND `price` BETWEEN '200000' AND '300000';";
        } else if ($price == 6) {
            $mainQuery .= " AND `price` >= '300000';";
        }

        $variants_rs = Database::search($mainQuery);

        $mainQuery = str_replace("*", "DISTINCT `product`.`id`", $mainQuery);
        $products = Database::search($mainQuery);

        if ($variants_rs->num_rows == 0) {

        ?>

            <div class="col-12">
                <div class="row d-flex flex-row justify-content-evenly">
                    <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 500px;">
                    <span class="noresultsText text-center">No Results Found. Try another way.</span>
                </div>
            </div>

            <?php

        } else {

            for ($b = 0; $b < $products->num_rows; $b++) {
                $products_data = $products->fetch_assoc();

                $cover_img_rs = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '" . $products_data["id"] . "' ");
                $cover_img_data = $cover_img_rs->fetch_assoc();

                $productTitle = null;
                $minPrice = 0;
                $maxPrice = 0;
                $minDiscount = 0;
                $maxDiscount = 0;

                foreach ($variants_rs as $variants_data) {

                    if ($variants_data["product_id"] == $products_data["id"]) {
                        if ($productTitle == null) {
                            $productTitle = $variants_data["title"];
                        }
                        if ($minPrice == 0 || $variants_data["price"] < $minPrice) {
                            $minPrice = $variants_data["price"];
                        }
                        if ($maxPrice == 0 || $variants_data["price"] > $maxPrice) {
                            $maxPrice = $variants_data["price"];
                        }
                        if ($minDiscount == 0 || $variants_data["discount"] < $minDiscount) {
                            $minDiscount = $variants_data["discount"];
                        }
                        if ($maxDiscount == 0 || $variants_data["discount"] > $maxDiscount) {
                            $maxDiscount = $variants_data["discount"];
                        }
                    }
                }

                if ($minPrice == $maxPrice) {
                    $minPrice = 0;
                }
                if ($minDiscount == $maxDiscount) {
                    $minDiscount = 0;
                }

            ?>

                <div class="card" style="width: 18rem;">
                    <div class="col-12 d-flex flex-column align-items-center justify-content-center mt-2" style="height: 250px;">
                        <img src="<?php echo ($cover_img_data["path"]); ?>" class="card-img-top cardimg rounded border border-dark border-2 border-opacity-10" alt="..." id="pImg<?php echo ($cover_img_data["cover_images_id"]); ?>" onerror="productImageError('pImg<?php echo ($cover_img_data['cover_images_id']); ?>')">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo ($productTitle); ?></h5>
                        <?php

                        if ($maxDiscount != 0) {
                        ?>
                            <span class="badge rounded-pill text-bg-danger bg-opacity-75 fs-6">
                                <?php if ($minDiscount != 0) {
                                    echo ($minDiscount)
                                ?>
                                    &percnt;&nbsp;&hyphen;&nbsp;
                                <?php
                                }
                                if ($maxDiscount != 0) {
                                    echo ($maxDiscount);
                                ?>
                                    &percnt; Discounts&excl;
                                <?php
                                }

                                ?>

                            </span><br>
                        <?php
                        }

                        ?>

                        <span class="card-text text-primary">Rs.
                            <?php

                            if ($minPrice != 0) {
                                echo ($minPrice . " - ");
                            }

                            echo ($maxPrice);

                            ?>
                        </span><br />
                        <a class="col-12 btn btn-outline-success stretched-link" href="singleProductView.php?product_id=<?php echo ($products_data["id"]) ?>">View</a>
                    </div>
                </div>
<?php


            }
        }
    }
} else {
    echo ("1");
}
