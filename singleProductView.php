<?php

require "connection.php";

if (isset($_GET["product_id"])) {

    $product_id = $_GET["product_id"];

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $product_id . "' AND `status` = '1'");

    if ($product_rs->num_rows == 0) {
        header("Location:index.php");
    } else {

        $product_data = $product_rs->fetch_assoc();

        $reviews = Database::search("SELECT * FROM `product_reviews` WHERE `product_id` = '$product_id'");

?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title><?php echo ($product_data["title"]) ?></title>

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
            <link rel="stylesheet" href="./css/main.min.css">
            <link rel="stylesheet" href="style.css" />

            <link rel="icon" href="resources/logo_title.png" />

        </head>

        <body>

            <div class="container-fluid">
                <?php include "userHeader.php"; ?>
                <div class="row">

                    <?php

                    $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '$product_id'");
                    $variant_num = $variant_rs->num_rows;

                    for ($x = 1; $x <= $variant_num; $x++) {
                        $variant_data[$x] = $variant_rs->fetch_assoc();
                    }

                    $cover_images_rs = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '$product_id'");
                    $cover_images_num = $cover_images_rs->num_rows;

                    for ($y = 0; $y < $cover_images_num; $y++) {
                        $cover_images_data[$y] = $cover_images_rs->fetch_assoc();
                    }

                    ?>

                    <div class="col-12 px-5">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-5">
                                <div class="row px-2">
                                    <div class="col-12 border border-2 border-redM border-opacity-25 my-3 py-2 px-4">
                                        <div class="row my-2">
                                            <nav>
                                                <div class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                                    <?php

                                                    for ($a = 0; $a < $cover_images_num; $a++) {
                                                    ?>

                                                        <button class="nav-link<?php if ($a == 0) { ?> active<?php } ?>" id="cover" data-bs-toggle="tab" data-bs-target="#cImg<?php echo ($a) ?>" type="button" role="tab" aria-controls="cImg<?php echo ($a) ?>" aria-selected="<?php if ($a == 0) {
                                                                                                                                                                                                                                                                                    ?>true<?php
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                            ?>false<?php
                                                                                                                                                                                                                                                                                                } ?>">
                                                            <img src="<?php echo ($cover_images_data[$a]["path"]) ?>" class="singleProductImg" id="pImg<?php echo ($cover_images_data[$a]["cover_images_id"]); ?>" onerror="productImageError('pImg<?php echo ($cover_images_data[$a]['cover_images_id']); ?>')" />
                                                        </button>

                                                    <?php
                                                    }

                                                    ?>
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="myTabContent">

                                                <?php

                                                for ($z = 0; $z < $cover_images_num; $z++) {
                                                ?>
                                                    <div class="tab-pane fade<?php if ($z == 0) { ?> show active<?php } ?>" id="cImg<?php echo ($z) ?>" role="tabpanel" aria-labelledby="cImg<?php echo ($z) ?>-tab" tabindex="0">
                                                        <div class="col-12 d-flex flex-column align-items-center justify-content-center my-3">
                                                            <img src="<?php echo ($cover_images_data[$z]["path"]) ?>" class="singleProductMainImg" id="pImg2<?php echo ($cover_images_data[$z]["cover_images_id"]); ?>" onerror="productImageError('pImg2<?php echo ($cover_images_data[$z]['cover_images_id']); ?>')" />
                                                            <!-- <img src="./resources/signinupBg2.jpg" class="singleProductMainImg" id="pImg2<?php echo ($cover_images_data[$z]["cover_images_id"]); ?>" onerror="productImageError('pImg2<?php echo ($cover_images_data[$z]['cover_images_id']); ?>')" /> -->
                                                        </div>
                                                    </div>
                                                <?php
                                                }

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5 my-3">
                                <div class="row">
                                    <div class="col-12 mt-2 mb-1">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active" aria-current="page"><?php echo ($product_data["title"]) ?></li>
                                            </ol>
                                        </nav>
                                    </div>
                                    <div class="col-12">
                                        <h4 class="text-dark fw-bold"><?php echo ($product_data["title"]) ?></h4>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <span class="badge">
                                            <?php

                                            $totalStars = Database::search("SELECT SUM(`star_count`) AS `total_stars` FROM `product_reviews` WHERE `product_id` = '$product_id'");
                                            $totalStarsData = $totalStars->fetch_assoc();

                                            $number_of_reviews = $reviews->num_rows;

                                            if ($number_of_reviews == 0) {

                                                for ($j = 0; $j < 5; $j++) {
                                            ?>

                                                    <i class="bi bi-star text-warning"></i>

                                                <?php
                                                }

                                                ?>

                                                &nbsp;&nbsp;
                                                <label class="text-black-50 fw-bold" style="font-size: 12px;">0 Stars | No Ratings Yet</label>

                                                <?php

                                            } else {
                                                $average_star_count = $totalStarsData["total_stars"] / $number_of_reviews;

                                                $rounded_average_star_count = round($average_star_count);

                                                if ($rounded_average_star_count > $average_star_count) {
                                                    for ($h = 0; $h < floor($average_star_count); $h++) {
                                                ?>

                                                        <i class="bi bi-star-fill text-warning"></i>

                                                    <?php
                                                    }
                                                    ?>

                                                    <i class="bi bi-star-half text-warning"></i>

                                                    <?php

                                                    for ($i = 0; $i < (4 - floor($average_star_count)); $i++) {
                                                    ?>

                                                        <i class="bi bi-star text-warning"></i>

                                                    <?php
                                                    }

                                                    ?>

                                                    &nbsp;&nbsp;
                                                    <label class="text-black-50 fw-bold" style="font-size: 12px;"><?php echo (floor($average_star_count)); ?>.5 Stars | <?php echo ($number_of_reviews); ?> Ratings</label>

                                                    <?php

                                                } else {

                                                    for ($h = 0; $h < $rounded_average_star_count; $h++) {
                                                    ?>

                                                        <i class="bi bi-star-fill text-warning"></i>

                                                    <?php
                                                    }

                                                    for ($i = 0; $i < (5 - $rounded_average_star_count); $i++) {
                                                    ?>

                                                        <i class="bi bi-star text-warning"></i>

                                                    <?php
                                                    }
                                                    ?>

                                                    &nbsp;&nbsp;
                                                    <label class="text-black-50 fw-bold" style="font-size: 12px;"><?php echo ($rounded_average_star_count); ?> Stars | <?php echo ($number_of_reviews); ?> Ratings</label>

                                            <?php
                                                }
                                            }

                                            ?>
                                        </span>
                                    </div>
                                    <div class="col-12 col-md-6 text-md-end my-2 my-md-0 ms-2 ms-md-0">
                                        <i class="bi bi-share-fill fs-4" style="cursor: pointer;"></i>&nbsp;&nbsp;&nbsp;

                                        <?php

                                        if (isset($_SESSION["user"])) {

                                            $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `product_id` = '$product_id' AND  `user_email` = '" . $_SESSION["user"]["email"] . "'");
                                            $wishlist_num = $wishlist_rs->num_rows;

                                            if ($wishlist_num == 0) {

                                        ?>

                                                <i class="bi bi-suit-heart fs-4" id="wishlistIcon" onclick="addToWishlist('<?php echo ($product_id); ?>');" style="cursor: pointer;"></i>

                                            <?php

                                            } else {

                                            ?>

                                                <i class="bi bi-suit-heart-fill fs-4 text-danger" id="wishlistIcon" onclick="addToWishlist('<?php echo ($product_id); ?>');" style="cursor: pointer;"></i>

                                            <?php

                                            }
                                        } else {
                                            ?>

                                            <i class="bi bi-suit-heart fs-4" id="wishlistIcon" onclick="notSignedIn();" style="cursor: pointer;"></i>

                                        <?php
                                        }

                                        ?>

                                    </div>
                                    <div class="col-6"></div>
                                    <div>
                                        <hr class="border-redM" />
                                    </div>
                                    <div class="col-12 mt-2 text-start">
                                        <span class="text-secondary fw-bold">Number of Variants : </span>
                                        <span class="fw-bold"><?php echo ($variant_num); ?></span>
                                    </div>
                                    <div class="col-12 col-lg-4 mt-4">
                                        <span class="text-secondary fw-bold">Select Variant : </span>
                                    </div>
                                    <div class="col-12 col-lg-8 mt-4">
                                        <select class="form-select" onchange="loadVariant('<?php echo ($product_id); ?>');" id="variant">
                                            <option value="0">-Select-</option>

                                            <?php

                                            for ($c = 1; $c <= $variant_num; $c++) {
                                            ?>

                                                <option value="<?php echo ($variant_data[$c]["id"]); ?>"><?php echo ($variant_data[$c]["variant_title"]); ?></option>

                                            <?php
                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-8 offset-lg-2 my-2 d-flex flex-column align-items-center">
                                        <img src="resources/select_variant.png" class="singleProductVariantImg" id="variantImg">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row">
                                            <div class="col-5 mt-4 ">
                                                <span class="text-secondary fw-bold">Stock Available : </span>
                                            </div>
                                            <div class="col-7 mt-4">
                                                <input class="form-control" type="text" disabled placeholder="Select Variant" id="variantQty" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-12 col-lg-4 mt-4">
                                        <span class="text-secondary fw-bold">Price : </span><br />

                                        <?php

                                        $variant2 = Database::search("SELECT MIN(`price`) AS `starting_price` FROM `variant` WHERE `product_id` = '$product_id'");
                                        $variant_data2 = $variant2->fetch_assoc();

                                        ?>

                                        <small class="text-black-50 fw-bold">(Starting at Rs. <?php echo ($variant_data2["starting_price"]); ?>)</small>
                                        <br><span id="discount" class="text-danger fw-bold"></span>
                                    </div>
                                    <div class="col-12 col-lg-8 mt-4">
                                        <div class="priceDiv d-flex flex-row align-items-center rounded border border-1 p-2 overflow-hidden">
                                            <span class="px-2">Rs.</span>
                                            <div class="vr"></div>
                                            <span id="variantPrice" class="px-2">Select Variant</span>
                                            <span id="discountedPrice" class="text-danger fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="col-12 mt-4">
                                            <span class="text-secondary fw-bold">Delivery(within Colombo) : </span>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">Rs.</span>
                                                <input value="" id="variantDwc" disabled type="text" class="form-control" placeholder="Select Variant" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="col-12 mt-4">
                                            <span class="text-secondary fw-bold">Delivery(outside Colombo) : </span>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon2">Rs.</span>
                                                <input value="" id="variantDoc" disabled type="text" class="form-control" placeholder="Select Variant" aria-label="Username" aria-describedby="basic-addon2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100 mt-4 p-2 d-flex align-items-center gap-2">
                                        <span class="text-secondary fw-bold">Quantity : </span>
                                        <input class="form-control w-auto" type="number" id="selectedQty" min="1" value="1" />
                                        <button class="btn btn-outline-danger" id="addToCartBtn" disabled onclick="addToCart();">Add To Cart</button>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row px-4">
                                            <button class="btn btn-outline-success" disabled id="buyNowBtn" onclick="buyNow();">Buy Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <div class="descRevDiv">
                                <nav>
                                    <div class="nav nav-tabs" id="myTab" role="tablist">
                                        <button class="nav-link active" id="cover" data-bs-toggle="tab" data-bs-target="#variantDescription" type="button" role="tab" aria-controls="variantDescription" aria-selected="true">
                                            Description
                                        </button>
                                        <button class="nav-link" id="cover" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="true">
                                            Reviews
                                        </button>
                                        <button class="nav-link" id="cover" data-bs-toggle="tab" data-bs-target="#related" type="button" role="tab" aria-controls="related" aria-selected="true">
                                            Related Products
                                        </button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active p-3" id="variantDescription" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                                        <div class="col-12 d-flex flex-column align-items-center justify-content-center my-3">
                                            <div class="col-12 my-2">
                                                <div class="row d-flex flex-row justify-content-evenly">
                                                    <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                                                    <span class="noresultsText text-center">No Variant Selected</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade p-3" id="reviews" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
                                        <div class="col-12">
                                            <div class="row">

                                                <?php

                                                if ($reviews->num_rows == 0) {

                                                ?>

                                                    <div class="col-12 my-2">
                                                        <div class="row d-flex flex-row justify-content-evenly">
                                                            <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 30rem;">
                                                            <span class="noresultsText text-center">No Ratings Yet...</span>
                                                        </div>
                                                    </div>

                                                    <?php

                                                } else {
                                                    for ($b = 0; $b < $reviews->num_rows; $b++) {
                                                        $reviewsData = $reviews->fetch_assoc();

                                                        $user = Database::search("SELECT * FROM `user` WHERE `email` = '" . $reviewsData["user_email"] . "'");
                                                        $userData = $user->fetch_assoc();

                                                        $variant3 = Database::search("SELECT * FROM `variant` WHERE `id` = '" . $reviewsData["variant_id"] . "'");
                                                        $variant_data3 = $variant3->fetch_assoc();

                                                    ?>

                                                        <div class="w-100 my-2 border border-2 rounded-3 p-2 bg-opacity-10 <?php echo ($reviewsData["star_count"] > 2 ? "border-success bg-success" : "border-danger bg-danger"); ?> ">
                                                            <span><?php echo ($userData["fname"] . " " . $userData["lname"]); ?></span><br />

                                                            <?php

                                                            for ($f = 0; $f < $reviewsData["star_count"]; $f++) {
                                                            ?>

                                                                <i class="bi bi-star-fill text-warning"></i>

                                                            <?php
                                                            }

                                                            for ($g = 0; $g < (5 - $reviewsData["star_count"]); $g++) {
                                                            ?>

                                                                <i class="bi bi-star text-warning"></i>

                                                            <?php
                                                            }

                                                            ?>
                                                            <br /><span><?php echo ($reviewsData["description"]); ?></span>
                                                            <br><span class="text-black-50">Variant : <?php echo ($variant_data3["variant_title"]); ?></span>
                                                        </div>

                                                <?php

                                                    }
                                                }

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade p-3" id="related" role="tabpanel" aria-labelledby="related-tab" tabindex="0">
                                        <div class="col-12">
                                            <div class="row gap-2 justify-content-center justify-content-lg-start">

                                                <?php

                                                $brand_has_category_rs = Database::search("SELECT * FROM `brand_has_category` WHERE `id` = '" . $product_data["brand_has_category_id"] . "'");
                                                $brand_has_category_data = $brand_has_category_rs->fetch_assoc();

                                                $query = "SELECT DISTINCT `id` FROM `brand_has_category` WHERE `brand_id` = '" . $brand_has_category_data["brand_id"] . "' 
                                                OR `category_id` = '" . $brand_has_category_data["category_id"] . "' OR `sub_categories_id` = '" . $brand_has_category_data["sub_categories_id"] . "'";

                                                $related_rs = Database::search("SELECT * FROM `product` WHERE (`brand_has_category_id` IN (".$query.") OR `title` LIKE '%" . $product_data["title"] . "%') AND `status` = '1'");
                                                $related_num = $related_rs->num_rows;

                                                if ($related_num <= 1) {
                                                ?>

                                                    <div class="col-12 my-2">
                                                        <div class="row d-flex flex-row justify-content-evenly">
                                                            <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                                                            <span class="noresultsText text-center">No Related Products</span>
                                                        </div>
                                                    </div>

                                                    <?php
                                                } else {

                                                    for ($d = 0; $d < $related_num; $d++) {

                                                        $related_data = $related_rs->fetch_assoc();

                                                        if ($related_data["id"] != $product_data["id"]) {

                                                            $cover_img_rs = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '" . $related_data["id"] . "' ");
                                                            $cover_img_data = $cover_img_rs->fetch_assoc();

                                                            $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $related_data["id"] . "' ORDER BY `price` ASC");
                                                            $variant_data = $variant_rs->fetch_assoc();

                                                            $min_price = $variant_data["price"];
                                                            $max_price = "";

                                                            $variant_num = $variant_rs->num_rows;

                                                            if ($variant_num > 0) {
                                                                $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $related_data["id"] . "' ORDER BY `price` DESC");
                                                                $variant_data = $variant_rs->fetch_assoc();

                                                                if ($min_price != $variant_data["price"]) {
                                                                    $max_price = $variant_data["price"];
                                                                }
                                                            }

                                                    ?>

                                                            <div class="card" style="width: 18rem;">
                                                                <div class="col-12 d-flex flex-column align-items-center justify-content-center mt-2" style="height: 250px;">
                                                                    <img src="<?php echo ($cover_img_data["path"]); ?>" class="card-img-top cardimg rounded border border-dark border-2 border-opacity-10" alt="..." id="pImg3<?php echo ($cover_img_data["cover_images_id"]); ?>" onerror="productImageError('pImg3<?php echo ($cover_img_data['cover_images_id']); ?>')">
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title"><?php echo ($related_data["title"]); ?></h5>
                                                                    <span class="card-text text-primary">Rs. <?php echo ($min_price);

                                                                                                                if (!empty($max_price)) {
                                                                                                                    echo (" - " . $max_price);
                                                                                                                }

                                                                                                                ?></span><br />
                                                                    <a class="col-12 btn btn-outline-success" href="singleProductView.php?product_id=<?php echo ($related_data["id"]) ?>">View</a>
                                                                </div>
                                                            </div>

                                                <?php
                                                        }
                                                    }
                                                }

                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 my-3">

                        </div>
                    </div>
                    <?php include "payhereDismissed.php"; ?>
                    <?php include "payhereError.php"; ?>
                    <?php include "footer.php"; ?>
                </div>
            </div>

            <script src="script.js"></script>
            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

        </body>

        </html>

    <?php
    }
} else {

    ?>

    <script>
        alert("Something went wrong. Please try again");
        window.location = "index.php";
    </script>

<?php

}
