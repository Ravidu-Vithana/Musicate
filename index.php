<?php

require "connection.php";

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home | Musicate</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./css/main.min.css">

    <link rel="icon" href="resources/logo_title.png" />

</head>

<body>
    <div class="container-fluid">
        <?php include "userHeader.php"; ?>
        <div class="row">

            <div class="col-12">
                <div class="row">

                    <!-- search -->
                    <div class="col-12 mt-4 mb-4 py-2 bg-secondary bg-opacity-10">
                        <div class="row">
                            <div class="col-md-8 col-10 offset-md-2 offset-1">
                                <div class="row gap-0">
                                    <div class="col-7 col-md-4">
                                        <input class="form-control" type="text" placeholder="Search in Musicate" id="searchInput" />
                                    </div>
                                    <div class="col-5 col-md-4">
                                        <?php

                                        $category_rs = Database::search("SELECT * FROM `category`");
                                        $category_num = $category_rs->num_rows;

                                        ?>
                                        <select class="form-select" id="searchCategory">
                                            <option value="0">All Categories</option>
                                            <?php

                                            for ($x = 0; $x < $category_num; $x++) {

                                                $category_data = $category_rs->fetch_assoc();

                                            ?>

                                                <option value="<?php echo ($category_data["id"]); ?>"><?php echo ($category_data["category_name"]); ?></option>

                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-4 col-md-2 offset-2 offset-md-0 d-grid mt-2 mt-md-0">
                                        <button class="btn btn-outline-primary" onclick="search();"><i class="bi bi-search"></i></button>
                                    </div>
                                    <div class="col-4 col-md-2 py-2 mt-2 mt-md-0">
                                        <a class="text-decoration-none" style="cursor: pointer;" href="advancedSearch.php">Advanced</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- search -->

                    <div class="col-12 my-3" id="mainView">
                        <div class="row">

                            <!-- carousel -->
                            <div class="col-8 offset-2 d-none d-lg-block mb-5">
                                <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
                                    </div>

                                    <div class="carousel-inner">
                                        <div class="carousel-item active carouselImg img1" data-bs-interval="4000">
                                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                                <h2 class="text-warning">Dive Deep In To The World Of Music!</h2>
                                            </div>
                                        </div>
                                        <div class="carousel-item carouselImg img2" data-bs-interval="4000">
                                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                                <h2 class="text-warning">Genuine Shop Warranty and Free Servicing!</h2>
                                            </div>
                                        </div>
                                        <div class="carousel-item carouselImg img3" data-bs-interval="4000">
                                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                                <h2 class="text-warning">Check Out Our Online Courses!!!</h2>
                                                <p><a href="#" class="text-decoration-none text-white fs-5">Click Here To See</a></p>
                                            </div>
                                        </div>
                                        <div class="carousel-item carouselImg img4" data-bs-interval="4000">
                                            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                                                <h2 class="text-warning">The Ultimate Music Store!!</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                            <!-- carousel -->

                            <!-- Quick Sort -->

                            <?php

                            $category_rs = Database::search("SELECT * FROM `category`");
                            $category_num = $category_rs->num_rows;

                            ?>

                            <div class="col-12 col-lg-3 border border-dark border-2 border-opacity-10 bg-secondary bg-opacity-10 mb-3">
                                <div class="row">
                                    <div class="col-12 text-center my-2 py-3">
                                        <span class="h3 quicksort">Quick Sort</span>
                                    </div>
                                    <div class="col-12 col-xl-11 offset-xl-1 my-3">
                                        <h3 class="h4 fw-bold">Categories</h3>
                                    </div>
                                    <div class="col-12 col-xl-11 offset-xl-1 d-flex flex-column">
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" value="0" id="categorycheck0" onclick="homeSort('<?php echo ($category_num); ?>','0');" checked>
                                            <label class="form-check-label" for="categorycheck0">
                                                All Categories
                                            </label>
                                        </div>
                                        <?php

                                        for ($y = 0; $y < $category_num; $y++) {

                                            $category_data = $category_rs->fetch_assoc();

                                        ?>

                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="checkbox" value="<?php echo ($category_data["id"]); ?>" id="categorycheck<?php echo ($category_data["id"]); ?>" onchange="homeSort('<?php echo ($category_num); ?>','<?php echo ($category_data['id']); ?>');">
                                                <label class="form-check-label" for="categorycheck<?php echo ($category_data["id"]); ?>">
                                                    <?php echo ($category_data["category_name"]); ?>
                                                </label>
                                            </div>

                                        <?php

                                        }

                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-xl-11 offset-xl-1 my-3">
                                        <h3 class="h4 fw-bold">Price Range</h3>
                                    </div>
                                    <div class="col-12 col-xl-11 offset-xl-1 d-flex flex-column">
                                        <select class="form-select" onchange="homeSort('<?php echo ($category_num); ?>');" id="homePriceSort">
                                            <option value="0">All Price Ranges</option>
                                            <option value="1">LKR 50000 and under</option>
                                            <option value="2">LKR 50000 to LKR 100000</option>
                                            <option value="3">LKR 100000 to LKR 150000</option>
                                            <option value="4">LKR 150000 to LKR 200000</option>
                                            <option value="5">LKR 200000 to LKR 300000</option>
                                            <option value="6">LKR 300000 and above</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Quick Sort -->
                            <div class="col-12 col-lg-9">
                                <div class="row">
                                    <div class="col-12 py-0">
                                        <hr />
                                    </div>
                                    <!-- current viewing category -->
                                    <div class="col-12">
                                        <div class="row d-flex flex-row align-items-center">
                                            <div class="col-12 mt-3">
                                                <span class="fw-bold h3 text-black-50">Viewing</span>
                                            </div>
                                            <div class="col-12 px-4 pt-2">
                                                <div class="row gap-1" id="viewType">
                                                    <div class="d-flex flex-row mb-1 selectedDiv" style="width: auto; height: auto;">
                                                        <span class="my-auto mx-auto">All categories</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                    <!-- current viewing category -->

                                    <!-- Product Viewing Area -->
                                    <div class="col-12 p-5 productsDiv">
                                        <div class="row gap-3 d-flex justify-content-evenly" id="productView">
                                            <?php

                                            $product_rs = Database::search("SELECT * FROM `product` WHERE `status` = '1'");
                                            $product_num = $product_rs->num_rows;

                                            for ($z = 0; $z < $product_num; $z++) {
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

                                                    for ($a = 0; $a < $variant_rs->num_rows; $a++) {
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

                                            ?>
                                        </div>
                                    </div>
                                    <!-- Product Viewing Area -->
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