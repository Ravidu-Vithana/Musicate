<?php

session_start();
require "connection.php";

$variant_no;

if (!isset($_SESSION["add"])) {

    $_SESSION["add"] = 1;
    $variant_no = $_SESSION["add"];
} else {

    $variant_no = $_SESSION["add"];
    $variant_no = $variant_no + 1;
    $_SESSION["add"] = $variant_no;
}

?>

<div class="row border rounded border-3 border-dark border-opacity-50 mt-4 px-1" id="variantDivNo<?php echo ($variant_no) ?>">
    <div class="col-12 p-2 text-center">
        <span class="fw-bold fs-4 title text-decoration-underline">Variant <?php echo ($variant_no) ?></span>
    </div>
    <div class="col-12 col-md-4 mt-2 text-center">
        <label class="form-label fw-bold fs-5">Variant Title</label><br>
        <span><i style="font-size: 12px;">(Include Main Title and Variant Property)</i></span>
        <input class="form-control" type="text" id="vTitle<?php echo ($variant_no) ?>" />
    </div>
    <div class="col-12 col-md-4 text-center mt-2">
        <label class="form-label fw-bold fs-5">Product Condition</label>
        <select class="form-select" id="con<?php echo ($variant_no) ?>">
            <option value="0">Select Condition</option>
            <?php

            $condition_rs = Database::search("SELECT * FROM `condition`");
            $condition_num = $condition_rs->num_rows;

            for ($x = 0; $x < $condition_num; $x++) {
                $condition_data = $condition_rs->fetch_assoc();
            ?>

                <option value="<?php echo ($condition_data["id"]); ?>"><?php echo ($condition_data["condition_name"]); ?></option>

            <?php
            }

            ?>
        </select>
    </div>
    <div class="col-12 col-md-4 text-center mt-2">
        <label class="form-label fw-bold fs-5">Cost Per Item</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Rs.</span>
            <input type="text" class="form-control" id="cost<?php echo ($variant_no) ?>" />
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
            <input type="text" class="form-control" id="dwc<?php echo ($variant_no) ?>" />
        </div>
        <label class="form-label fw-bold fs-6">Outside Colombo</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Rs.</span>
            <input type="text" class="form-control" id="doc<?php echo ($variant_no) ?>" />
        </div>
    </div>
    <div class="col-12 col-md-8 text-center mt-2">
        <label class="form-label fw-bold fs-5">Product Description</label>
        <textarea class="form-control" rows="8" id="des<?php echo ($variant_no) ?>"></textarea>
    </div>
    <div class="col-12 d-none d-md-block">
        <hr style="border-width: 3px;" />
    </div>
    <div class="col-12 col-md-2 text-center mt-2">
        <label class="form-label fw-bold fs-5">Quantity</label>
        <input class="form-control" type="number" min="1" value="1" id="qty<?php echo ($variant_no) ?>" />
    </div>
    <div class="col-12 col-md-2 text-center mt-2">
        <label class="form-label fw-bold fs-5">Discount</label>
        <br><span><i style="font-size: 12px;">Please insert the Percentage value*</i></span>
        <input class="form-control" type="number" min="0" max="100" value="0" id="discount<?php echo ($variant_no) ?>" />
    </div>
    <div class="col-12 col-md-5 mt-2">
        <div class="row">
            <div class="col-12 text-center">
                <label class="form-label fw-bold fs-5">Add Variant Images</label><br />
                <span>(Only one image per variant)</span><br />
                <span><i style="font-size: 12px;">only jpg, jpeg, png and svg files allowed*</i></span>
            </div>
            <div class="col-12">
                <div class="row d-flex flex-column align-items-center">
                    <div class="col-4 border border-success rounded d-flex flex-column align-items-center">
                        <img src="resources/addproductimg.svg" class="img-fluid" style="max-width: 100px;" id="vi<?php echo ($variant_no) ?>" />
                    </div>
                </div>
            </div>
            <div class="col-12 my-3 d-flex flex-column align-items-center">
                <input type="file" class="d-none" id="vImage<?php echo ($variant_no) ?>" name="vImage<?php echo ($variant_no) ?>" />
                <label for="vImage<?php echo ($variant_no) ?>" class="btn btn-outline-primary fw-bold" onclick="variantImages('<?php echo ($variant_no) ?>');">Upload Images</label>
            </div>
        </div>
    </div>
</div>