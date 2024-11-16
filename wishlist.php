<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $user_email = $_SESSION["user"]["email"];

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wishlist | Musicate</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="./css/main.min.css">

        <link rel="icon" href="resources/logo_title.png" />

    </head>

    <body>

        <div class="container-fluid">
            <?php include "userHeader.php"; ?>
            <div class="row">

                <?php

                $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `user_email` = '$user_email'");
                $wishlist_num = $wishlist_rs->num_rows;

                ?>

                <div class="col-12 mt-4">
                    <div class="row d-flex flex-column align-items-center">
                        <div class="col-12 d-flex justify-content-center" style="background-image: url(./resources/wishlistBg.jpg); background-size: cover; background-position: center; padding-top: 4rem; padding-bottom: 4rem;">
                            <h1 class="h1 d-flex align-items-center title text-white">
                                Wishlist
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white" style="height: 3rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            </h1>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-md-6 col-8 offset-2 offset-md-3">
                                    <input class="form-control" type="text" placeholder="Search Wishlist" onkeyup="searchWishlist();" id="search" <?php if ($wishlist_num == 0) { ?> disabled <?php } ?> />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="border-redM" />
                        </div>
                        <div class="col-12 col-md-10 col-lg-8 my-3">
                            <div class="row">
                                <div class="col-12 d-none" id="searchContentDiv"></div>
                                <div class="col-12" id="mainContentDiv">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="wishlist-tab" data-bs-toggle="tab" data-bs-target="#wishlist-tab-pane" type="button" role="tab" aria-controls="wishlist-tab-pane" aria-selected="true">Wishlist</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="recents-tab" data-bs-toggle="tab" data-bs-target="#recents-tab-pane" type="button" role="tab" aria-controls="recents-tab-pane" aria-selected="false">Recents</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="wishlist-tab-pane" role="tabpanel" aria-labelledby="wishlist-tab" tabindex="0">
                                            <div class="col-12">
                                                <div class="row">
                                                    <?php

                                                    if ($wishlist_num == 0) {

                                                    ?>

                                                        <div class="col-12 my-2">
                                                            <div class="row d-flex flex-row justify-content-evenly">
                                                                <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                                                                <span class="noresultsText text-center">No Items In Your Wishlist Yet...</span>
                                                                <div class="col-12 d-flex flex-column align-items-center">
                                                                    <a class="btn btn-outline-success fs-4 fw-bold my-3" href="index.php">Start Shopping</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php

                                                    } else {

                                                        $status = 0;

                                                        for ($x = 0; $x < $wishlist_num; $x++) {
                                                            $wishlist_data = $wishlist_rs->fetch_assoc();

                                                            $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $wishlist_data["product_id"] . "' AND `status` = '1'");

                                                            if ($product_rs->num_rows == 1) {

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
                                                                <div class="col-10 col-lg-8 offset-1 offset-lg-2 my-2 border border-2 border-danger border-opacity-50 rounded p-3">
                                                                    <div class="row">
                                                                        <div class="col-12 col-md-5 d-flex flex-column align-items-center">
                                                                            <img src="<?php echo ($cover_img_data["path"]); ?>" class="img-fluid" style="max-height: 200px;" id="pImg<?php echo ($cover_img_data["cover_images_id"]); ?>" onerror="productImageError('pImg<?php echo ($cover_img_data['cover_images_id']); ?>')">
                                                                        </div>
                                                                        <div class="col-12 col-md-7 text-center text-md-start">
                                                                            <h5 class="card-title mb-3"><?php echo ($product_data["title"]); ?></h5>
                                                                            <span class="card-text fw-bold text-danger">Price<?php if (!empty($max_price)) { ?> Range<?php } ?> : </span>
                                                                            <span class="card-text">Rs. <?php echo ($min_price);

                                                                                                        if (!empty($max_price)) {
                                                                                                            echo (" - " . $max_price);
                                                                                                        }

                                                                                                        ?></span><br />

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
                                                                    <span class="noresultsText text-center">No Items In Your Recents Yet...</span>
                                                                </div>
                                                            </div>

                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="recents-tab-pane" role="tabpanel" aria-labelledby="recents-tab" tabindex="0">
                                            <div class="col-12">
                                                <div class="row">

                                                    <?php

                                                    $recent_rs = Database::search("SELECT * FROM `recent` WHERE `user_email` = '$user_email'");
                                                    $recent_num = $recent_rs->num_rows;

                                                    if ($recent_num == 0) {

                                                    ?>

                                                        <div class="col-12 my-2">
                                                            <div class="row d-flex flex-row justify-content-evenly">
                                                                <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                                                                <span class="noresultsText text-center">No Items In Your Recents Yet...</span>
                                                            </div>
                                                        </div>

                                                        <?php

                                                    } else {

                                                        $status2 = 0;

                                                        for ($y = 0; $y < $recent_num; $y++) {

                                                            $recent_data = $recent_rs->fetch_assoc();

                                                            $product_rs2 = Database::search("SELECT * FROM `product` WHERE `id` = '" . $recent_data["product_id"] . "' AND `status` = '1'");

                                                            if ($product_rs2->num_rows == 1) {

                                                                $status2 = 1;
                                                                $product_data2 = $product_rs2->fetch_assoc();

                                                                $brand_has_category_rs2 = Database::search("SELECT * FROM `brand_has_category` WHERE `id` = '" . $product_data2["brand_has_category_id"] . "'");
                                                                $brand_has_category_data2 = $brand_has_category_rs2->fetch_assoc();

                                                                $brand_rs2 = Database::search("SELECT * FROM `brand` WHERE `id` = '" . $brand_has_category_data2["brand_id"] . "'");
                                                                $brand_data2 = $brand_rs2->fetch_assoc();

                                                                $category_rs2 = Database::search("SELECT * FROM `category` WHERE `id` = '" . $brand_has_category_data2["category_id"] . "'");
                                                                $category_data2 = $category_rs2->fetch_assoc();

                                                                $cover_img_rs2 = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '" . $product_data2["id"] . "' ");
                                                                $cover_img_data2 = $cover_img_rs2->fetch_assoc();

                                                                $variant_rs2 = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data2["id"] . "' ORDER BY `price` ASC");
                                                                $variant_data2 = $variant_rs2->fetch_assoc();

                                                                $min_price2 = $variant_data2["price"];
                                                                $max_price2 = "";

                                                                $variant_num2 = $variant_rs2->num_rows;

                                                                if ($variant_num2 > 0) {
                                                                    $variant_rs2 = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data2["id"] . "' ORDER BY `price` DESC");
                                                                    $variant_data2 = $variant_rs2->fetch_assoc();

                                                                    if ($min_price2 != $variant_data2["price"]) {
                                                                        $max_price2 = $variant_data2["price"];
                                                                    }
                                                                }

                                                        ?>

                                                                <!-- card -->
                                                                <div class="col-10 col-lg-8 offset-1 offset-lg-2 my-2 border border-2 border-secondary border-opacity-50 rounded p-3">
                                                                    <div class="row">
                                                                        <div class="col-12 col-md-5 d-flex flex-column align-items-center">
                                                                            <img src="<?php echo ($cover_img_data2["path"]); ?>" class="img-fluid" style="max-height: 200px;" id="pImg2<?php echo ($cover_img_data["cover_images_id"]); ?>" onerror="productImageError('pImg2<?php echo ($cover_img_data['cover_images_id']); ?>')">
                                                                        </div>
                                                                        <div class="col-12 col-md-7 text-center text-md-start">
                                                                            <h5 class="card-title mb-3"><?php echo ($product_data2["title"]); ?></h5>
                                                                            <span class="card-text fw-bold text-danger">Price Range : </span>
                                                                            <span class="card-text">Rs. <?php echo ($min_price2);

                                                                                                        if (!empty($max_price2)) {
                                                                                                            echo (" - " . $max_price2);
                                                                                                        }

                                                                                                        ?></span><br />
                                                                            <div class="col-12">
                                                                                <div class="accordion" id="accordionExample">
                                                                                    <div class="accordion-item">
                                                                                        <div class="accordion-item">
                                                                                            <h2 class="accordion-header" id="headingcard3">
                                                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#card<?php echo ($product_data2["id"]); ?>" aria-expanded="false" aria-controls="card3">
                                                                                                    Additional Details
                                                                                                </button>
                                                                                            </h2>
                                                                                            <div id="card<?php echo ($product_data2["id"]); ?>" class="accordion-collapse collapse" aria-labelledby="headingcard3" data-bs-parent="#accordionExample">
                                                                                                <div class="accordion-body">
                                                                                                    <span class="card-text fw-bold">Category : </span>
                                                                                                    <span class="card-text"><?php echo ($category_data2["category_name"]); ?></span><br />
                                                                                                    <span class="card-text fw-bold">Brand : </span>
                                                                                                    <span class="card-text"><?php echo ($brand_data2["brand_name"]); ?></span><br />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 my-2">
                                                                                <div class="row">
                                                                                    <div class="col-12 col-lg-6 mt-2 d-grid">
                                                                                        <a class="btn btn-outline-secondary" href="singleProductView.php?product_id=<?php echo ($product_data2["id"]) ?>"><i class="bi bi-box-arrow-up-right"></i> View</a>
                                                                                    </div>
                                                                                    <div class="col-12 col-lg-6 mt-2 d-grid">
                                                                                        <button class="btn btn-outline-danger" onclick="removeFromRecent('<?php echo ($product_data2['id']); ?>','<?php echo ($product_data2['title']); ?>');"><i class="bi bi-x-circle"></i> Remove</button>
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

                                                        if ($status2 == 0) {
                                                            ?>

                                                            <div class="col-12 my-2">
                                                                <div class="row d-flex flex-row justify-content-evenly">
                                                                    <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                                                                    <span class="noresultsText text-center">No Items In Your Recents Yet...</span>
                                                                </div>
                                                            </div>

                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include "footer.php"; ?>
            </div>
        </div>

        <script src="script.js"></script>

    </body>

    </html>

<?php

} else {
    header("Location:signIn.php");
}

?>