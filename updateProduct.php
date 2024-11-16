<?php

session_start();
require "connection.php";

if ($_GET["product_id"]) {
    $product_id = $_GET["product_id"];
    $_SESSION["updateProductID"] = $product_id;

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '$product_id'");
    $product_data = $product_rs->fetch_assoc();

    $brand_has_category_rs = Database::search("SELECT * FROM `brand_has_category` WHERE `id` = '" . $product_data["brand_has_category_id"] . "'");
    $brand_has_category_data = $brand_has_category_rs->fetch_assoc();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Product | Musicate</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="./css/main.min.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Pacifico&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

        <link rel="icon" href="resources/logo_title.png" />

    </head>

    <body onload="updateProductPage('<?php echo ($product_data['title']); ?>','<?php echo ($product_id); ?>');">

        <div class="container-fluid">
            <div class="row">
                <?php include "adminHeader.php"; ?>

                <div class="col-12">
                    <div class="row">
                        <div class="col-12 text-center text-white bg-dark bg-opacity-75 py-3">
                            <h3 class="h3 title">Update Product "<?php echo ($product_data["title"]) ?>"</h3>
                        </div>
                        <div class="col-12 bg-dark bg-opacity-10">
                            <div class="row">
                                <div class="col-12 col-md-4 text-center mt-2">
                                    <label class="form-label fw-bold fs-5">Category</label><br />
                                    <select class="form-select mb-2" disabled>
                                        <option value="0">Select Category</option>
                                        <?php
                                        $category_rs = Database::search("SELECT * FROM `category`");
                                        $category_num = $category_rs->num_rows;

                                        for ($x = 0; $x < $category_num; $x++) {

                                            $category_data = $category_rs->fetch_assoc();

                                        ?>

                                            <option <?php if ($category_data["id"] == $brand_has_category_data["category_id"]) { ?> selected <?php } ?>><?php echo ($category_data["category_name"]); ?></option>

                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 text-center mt-2">
                                    <label class="form-label fw-bold fs-5">Sub-category</label><br />
                                    <select class="form-select mb-2" disabled>
                                        <option value="0">Select category first</option>
                                        <?php
                                        $sub_categories_rs = Database::search("SELECT * FROM `sub_categories`");
                                        $sub_categories_num = $sub_categories_rs->num_rows;

                                        for ($x = 0; $x < $sub_categories_num; $x++) {

                                            $sub_categories_data = $sub_categories_rs->fetch_assoc();

                                        ?>

                                            <option <?php if ($sub_categories_data["id"] == $brand_has_category_data["sub_categories_id"]) { ?> selected <?php } ?>><?php echo ($sub_categories_data["sub_name"]); ?></option>

                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 text-center mt-2">
                                    <label class="form-label fw-bold fs-5">Brand</label><br />
                                    <select class="form-select mb-2" disabled>
                                        <option value="0">Select sub-category first</option>
                                        <?php
                                        $brand_rs = Database::search("SELECT * FROM `brand`");
                                        $brand_num = $brand_rs->num_rows;

                                        for ($x = 0; $x < $brand_num; $x++) {

                                            $brand_data = $brand_rs->fetch_assoc();

                                        ?>

                                            <option <?php if ($brand_data["id"] == $brand_has_category_data["brand_id"]) { ?> selected <?php } ?>><?php echo ($brand_data["brand_name"]); ?></option>

                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 d-none d-md-block">
                                    <hr style="border-width: 3px;" />
                                </div>
                                <div class="col-12 col-md-4 text-center mt-2">
                                    <label class="form-label fw-bold fs-5">Model</label><br />
                                    <select class="form-select mb-2" disabled id="m">
                                        <option value="0">Select brand first</option>
                                        <?php
                                        $model_rs = Database::search("SELECT * FROM `model`");
                                        $model_num = $model_rs->num_rows;

                                        for ($x = 0; $x < $model_num; $x++) {

                                            $model_data = $model_rs->fetch_assoc();

                                        ?>

                                            <option value="<?php echo ($model_data["id"]); ?>" <?php if ($model_data["id"] == $product_data["model_id"]) { ?> selected <?php } ?>><?php echo ($model_data["model_name"]); ?></option>

                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 mt-2 text-center">
                                    <label class="form-label fw-bold fs-5 ">Product Title</label>
                                    <div class="form-check my-2 text-start" onload="checkTitle();">
                                        <input class="form-check-input" type="checkbox" id="addmodelname" onclick="sameAsModel();">
                                        <label class="form-check-label" for="addmodelname">
                                            Same as Brand + Model Name
                                        </label>
                                    </div>
                                    <input class="form-control" type="text" id="title" value="<?php echo ($product_data['title']); ?>" />
                                </div>
                                <div class="col-12 col-md-4 mt-2">
                                    <div class="row">
                                        <?php

                                        $cover_images = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '$product_id'");
                                        $cover_images_num = $cover_images->num_rows;

                                        $remaining = 5 - $cover_images_num;

                                        ?>
                                        <div class="col-12 text-center">
                                            <label class="form-label fw-bold fs-5">Product Cover Images</label><br />
                                            <?php

                                            if ($remaining == 0) {
                                            ?>

                                                <span>No more images can be added)</span><br />

                                            <?php
                                            } else {
                                            ?>

                                                <span>(<?php echo ($remaining); ?> more image(s) can be added)</span><br />

                                            <?php
                                            }

                                            ?>
                                            <span><i style="font-size: 12px;">only jpg, jpeg, png and svg files allowed*</i></span>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="row d-flex flex-row justify-content-center">

                                                <?php

                                                for ($y = 0; $y < $cover_images_num; $y++) {
                                                    $cover_images_data = $cover_images->fetch_assoc();

                                                ?>

                                                    <div class="col-4 border border-success rounded d-flex flex-column align-items-center">
                                                        <button class="btn btn-danger my-1" onclick="deleteCoverImage('<?php echo ($cover_images_data['cover_images_id']); ?>');"><i class="bi bi-trash3"></i></button>
                                                        <img src="<?php echo ($cover_images_data["path"]); ?>" class="img-fluid" style="max-width: 100px;" id="i<?php echo $y; ?>" onerror="productImageError('i<?php echo $y; ?>');" />
                                                    </div>

                                                <?php

                                                }

                                                for ($z = 0; $z < $remaining; $z++) {
                                                ?>

                                                    <div class="col-4 border border-success rounded d-flex flex-column align-items-center justify-content-center">
                                                        <img src="resources/addproductimg.svg" class="img-fluid" style="max-width: 100px;" id="ir<?php echo $z; ?>" />
                                                    </div>

                                                <?php
                                                }

                                                ?>
                                            </div>
                                        </div>
                                        <div class="offset-lg-3 col-12 col-lg-6 d-grid mb-3 <?php if ($remaining == 0) { ?>d-none<?php } ?>">
                                            <input type="file" class="d-none" id="cImage" name="cImage" <?php if ($remaining > 1) { ?> multiple <?php } ?> />
                                            <label for="cImage" class="btn btn-outline-primary fw-bold" onclick="newCoverImages('<?php echo ($remaining); ?>','<?php echo ($product_id); ?>');">+ New Images</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-dark bg-dark bg-opacity-25 py-3">
                                    <h5 class="h5 title my-auto">Edit Product Variants</h5>
                                </div>

                                <!-- variant div -->
                                <div class="col-12 px-4" id="variantDiv"></div>
                                <!-- variant div -->

                                <div class="col-12">
                                    <div class="row" id="removeBtnDiv" style="display: none;">
                                        <div class="col-12 text-center mt-3">
                                            <button class="btn btn-danger fw-bold text-white" onclick="removeUpdateVariant();" id="removeBtn"><i class="bi bi-trash-fill"></i></button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center mt-3">
                                            <button class="btn btn-outline-dark fw-bold" onclick="newVariant();"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;New Variant</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr style="border-width: 3px;" />
                                </div>
                                <div class="col-12 col-md-4 offset-md-4 d-grid mb-3">
                                    <button class="btn btn-outline-success fw-bold" id="addProductBtn" onclick="updateProduct('<?php echo ($product_id); ?>');">Save</button>
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
    header("Location:adminPanel.php");
}
