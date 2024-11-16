<?php

session_start();
require "connection.php";

$product_id = $_SESSION["updateProductID"];

$variants = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_id . "' ORDER BY `datetime_added` ASC");
$variants_num = $variants->num_rows;

if ($variants_num > 0) {

    for ($x = 1; $x <= $variants_num; $x++) {
        $variants_data = $variants->fetch_assoc();

?>

        <div class="row border rounded border-3 border-dark border-opacity-50 mt-4 px-1" id="variantDivNo<?php echo ($x) ?>">
            <div class="col-12 p-2 text-center">
                <span class="fw-bold fs-4 title text-decoration-underline">Variant <?php echo ($x) ?></span>
                <?php
                if ($variants_num > 1) {
                ?>
                    <button class="btn btn-danger my-1" onclick="deleteVariant('<?php echo ($variants_data['id']); ?>');"><i class="bi bi-trash3"></i></button>
                <?php
                }
                ?>
            </div>
            <div class="col-12 col-md-4 mt-2 text-center">
                <label class="form-label fw-bold fs-5">Variant Title</label><br>
                <span><i style="font-size: 12px;">(Include Main Title and Variant Property)</i></span>
                <input class="form-control" value="<?php echo ($variants_data["variant_title"]); ?>" type="text" id="vTitle<?php echo ($x) ?>" />
            </div>
            <div class="col-12 col-md-4 text-center mt-2">
                <label class="form-label fw-bold fs-5">Product Condition</label>
                <select class="form-select" id="con<?php echo ($x) ?>">
                    <?php

                    $condition_rs = Database::search("SELECT * FROM `condition`");
                    $condition_num = $condition_rs->num_rows;

                    for ($y = 0; $y < $condition_num; $y++) {
                        $condition_data = $condition_rs->fetch_assoc();
                    ?>

                        <option value="<?php echo ($condition_data["id"]); ?>" <?php if ($variants_data["condition_id"] == $condition_data["id"]) { ?> selected <?php } ?>><?php echo ($condition_data["condition_name"]); ?></option>

                    <?php
                    }

                    ?>
                </select>
            </div>
            <div class="col-12 col-md-4 text-center mt-2">
                <label class="form-label fw-bold fs-5">Cost Per Item</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rs.</span>
                    <input type="text" value="<?php echo ($variants_data["price"]); ?>" class="form-control" id="cost<?php echo ($x) ?>" />
                </div>
            </div>
            <div class="col-12 d-none d-md-block">
                <hr style="border-width: 3px;" />
            </div>
            <div class="col-12 col-md-4 text-center mt-2">
                <label class="form-label fw-bold fs-5">Delivery Cost</label><br />
                <label class="form-label fw-bold fs-6">Within Colombo</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rs.</span>
                    <input type="text" value="<?php echo ($variants_data["delivery_fee_within_colombo"]); ?>" class="form-control" id="dwc<?php echo ($x) ?>" />
                </div>
                <label class="form-label fw-bold fs-6">Outside Colombo</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rs.</span>
                    <input type="text" value="<?php echo ($variants_data["delivery_fee_outside_colombo"]); ?>" class="form-control" id="doc<?php echo ($x) ?>" />
                </div>
            </div>
            <div class="col-12 col-md-8 text-center mt-2">
                <label class="form-label fw-bold fs-5">Product Description</label>
                <textarea class="form-control" rows="8" id="des<?php echo ($x) ?>"><?php echo ($variants_data["description"]); ?></textarea>
            </div>
            <div class="col-12 d-none d-md-block">
                <hr style="border-width: 3px;" />
            </div>
            <div class="col-12 col-md-2 text-center mt-2">
                <label class="form-label fw-bold fs-5">Quantity</label>
                <input class="form-control" value="<?php echo ($variants_data["qty"]); ?>" type="number" min="1" value="1" id="qty<?php echo ($x) ?>" />
            </div>
            <div class="col-12 col-md-2 text-center mt-2">
                <label class="form-label fw-bold fs-5">Discount</label>
                <br><span><i style="font-size: 12px;">Please insert the Percentage value*</i></span>
                <input class="form-control" type="number" min="0" max="100" value="<?php echo ($variants_data["discount"]); ?>" id="discount<?php echo ($x) ?>" />
            </div>
            <div class="col-12 col-md-5 mt-2">
                <div class="row">
                    <div class="col-12 text-center">
                        <label class="form-label fw-bold fs-5">Variant Images</label><br />
                        <span><i style="font-size: 12px;">only jpg, jpeg, png and svg files allowed*</i></span>
                    </div>
                    <div class="col-12">
                        <div class="row d-flex flex-column align-items-center">
                            <div class="col-4 border border-success rounded d-flex flex-column align-items-center">
                                <img src="<?php echo ($variants_data["image_path"]); ?>" class="img-fluid" style="max-width: 100px;" id="vi<?php echo ($x) ?>" onerror="productImageError('vi<?php echo ($x) ?>')" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12 my-3 d-flex flex-column align-items-center">
                        <input type="file" class="d-none" id="vImage<?php echo ($x) ?>" name="vImage<?php echo ($x) ?>" />
                        <label for="vImage<?php echo ($x) ?>" class="btn btn-outline-primary fw-bold" onclick="changeVariantImages('<?php echo ($x) ?>','<?php echo ($variants_data['id']); ?>');">Change Image</label>
                    </div>
                </div>
            </div>
        </div>

<?php

    }

    $_SESSION["add"] = $x - 1;
} else {
    echo ("1");
}

?>