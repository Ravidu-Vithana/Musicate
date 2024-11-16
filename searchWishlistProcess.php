<?php

session_start();
require "connection.php";

if (isset($_GET["input"])) {

    $input = $_GET["input"];

    if (!empty($input)) {
        $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `user_email` = '" . $_SESSION["user"]["email"] . "'");
        $wishlist_num = $wishlist_rs->num_rows;

        if ($wishlist_num > 0) {

            $status = 0;

            for ($x = 0; $x < $wishlist_num; $x++) {
                $wishlist_data = $wishlist_rs->fetch_assoc();

                $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $wishlist_data["product_id"] . "' 
                AND `title` LIKE '%" . $input . "%' AND `status` = '1'");
                $product_num = $product_rs->num_rows;

                if ($product_num == 1) {

                    $status = 1;
                    $product_data = $product_rs->fetch_assoc();

                    $brand_has_category_rs = Database::search("SELECT * FROM `brand_has_category` WHERE `id` = '" . $product_data["brand_has_category_id"] . "'");
                    $brand_has_category_data = $brand_has_category_rs->fetch_assoc();

                    $brand_rs = Database::search("SELECT * FROM `brand` WHERE `id` = '" . $brand_has_category_data["brand_id"] . "'");
                    $brand_data = $brand_rs->fetch_assoc();

                    $category_rs = Database::search("SELECT * FROM `category` WHERE `id` = '" . $brand_has_category_data["category_id"] . "'");
                    $category_data = $category_rs->fetch_assoc();

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

?>

                    <!-- card -->
                    <div class="col-10 col-lg-8 offset-1 offset-lg-2 my-2 border border-2 border-secondary border-opacity-50 rounded p-3">
                        <div class="row">
                            <div class="col-12 col-md-5 d-flex flex-column align-items-center">
                                <img src="<?php echo ($cover_img_data["path"]); ?>" class="img-fluid" style="max-height: 200px;" id="pImg<?php echo($cover_img_data["cover_images_id"]); ?>" onerror="productImageError('pImg<?php echo($cover_img_data['cover_images_id']); ?>')">
                            </div>
                            <div class="col-12 col-md-7 text-center text-md-start">
                                <h5 class="card-title mb-3"><?php echo ($product_data["title"]); ?></h5>
                                <span class="card-text fw-bold text-danger">Price<?php if (!empty($max_price)) { ?> Range<?php } ?> : </span>
                                <span class="card-text">Rs. <?php echo ($min_price);

                                                            if (!empty($max_price)) {
                                                                echo (" - " . $max_price);
                                                            }

                                                            ?></span><br />
                                <div class="col-12">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingcard3">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card<?php echo ($product_data["id"]); ?>" aria-expanded="false" aria-controls="card3">
                                                        Additional Details
                                                    </button>
                                                </h2>
                                                <div id="card<?php echo ($product_data["id"]); ?>" class="accordion-collapse collapse" aria-labelledby="headingcard3" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <span class="card-text fw-bold">Category : </span>
                                                        <span class="card-text"><?php echo ($category_data["category_name"]); ?></span><br />
                                                        <span class="card-text fw-bold">Brand : </span>
                                                        <span class="card-text"><?php echo ($brand_data["brand_name"]); ?></span><br />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 my-2">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 mt-2 d-grid">
                                            <a class="btn btn-outline-secondary" href="singleProductView.php?product_id=<?php echo ($product_data["id"]) ?>"><i class="bi bi-box-arrow-up-right"></i> View</a>
                                        </div>
                                        <div class="col-12 col-lg-6 mt-2 d-grid">
                                            <button class="btn btn-outline-danger" onclick="removeFromWishlist('<?php echo ($product_data['id']); ?>');"><i class="bi bi-x-circle"></i> Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- card -->

                <?php

                }
            }

            if ($status == 0) {
                ?>

                <div class="col-12 my-2">
                    <div class="row d-flex flex-row justify-content-evenly">
                        <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                        <span class="noresultsText text-center">No Results Found. Try another way.</span>
                    </div>
                </div>

<?php
            }
        } else {
            echo ("empty");
        }
    } else {
        echo ("empty");
    }
} else {
    echo ("1");
}
