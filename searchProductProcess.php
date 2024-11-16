<?php

require "connection.php";

if (isset($_GET["input"])) {

    $input = $_GET["input"];

    $results = Database::search("SELECT * FROM `product` WHERE `title` LIKE '%" . $input . "%'");

    if ($results->num_rows == 0) {
?>

        <div class="col-12 my-2">
            <div class="row d-flex flex-row justify-content-evenly">
                <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 40rem;">
                <span class="noresultsText text-center">No Results Found. Try another way.</span>
            </div>
        </div>

        <?php
    } else {
        for ($x = 0; $x < $results->num_rows; $x++) {
            $results_data = $results->fetch_assoc();

            $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $results_data["id"] . "'");
            $variant_num = $variant_rs->num_rows;

            $totalVariantQty = Database::search("SELECT SUM(qty) AS `total` FROM `variant` WHERE `product_id` = '" . $results_data["id"] . "'");
            $totalVariantQtyData = $totalVariantQty->fetch_assoc();

        ?>

            <div class="card mb-3" style="max-width: 35rem;">
                <div class="row g-0">
                    <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                        <?php

                        $cover_image_rs = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '" . $results_data["id"] . "'");
                        $cover_image_num = $cover_image_rs->num_rows;

                        if ($cover_image_num == 0) {
                        ?>

                            <img src="resources/no_image_available.jpg" class="img-fluid rounded" style="max-height: 10rem; max-width: 10rem;">

                        <?php
                        } else {
                            $cover_image_data = $cover_image_rs->fetch_assoc();
                        ?>

                            <img src="<?php echo ($cover_image_data["path"]); ?>" class="img-fluid rounded" id="coverImg<?php echo ($results_data["id"]); ?>" style="max-height: 10rem; max-width: 10rem;" onerror="productImageError('coverImg<?php echo ($results_data['id']); ?>');">

                        <?php
                        }

                        ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo ($results_data["title"]); ?></h5>
                            <span class="card-text text-primary"><?php echo ($variant_num); ?> Variant(s)</span><br />
                            <span class="card-text text-black-50 fw-bold">Total Quantity : <?php echo ($totalVariantQtyData["total"]); ?></span><br />
                            <span class="card-text text-black-50 fw-bold">Product ID : <?php echo ($results_data["id"]); ?></span><br />
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="productAct<?php echo ($results_data["id"]); ?>" <?php if ($results_data["status"] == 1) { ?> checked <?php } ?> onclick="productBlockStatus('<?php echo ($results_data['id']); ?>');">
                                <label class="form-check-label fw-bold text-<?php echo ($results_data["status"] == 1 ? "success" : "danger"); ?>" for="productAct<?php echo ($results_data["id"]); ?>" id="actDeactLabel<?php echo ($results_data["id"]); ?>">Product is <?php echo ($results_data["status"] == 1 ? "Active" : "Deactive"); ?></label>
                            </div>
                            <a class="btn btn-warning" href="updateProduct.php?product_id=<?php echo ($results_data['id']); ?>">Update</a>
                            <button class="btn btn-danger" onclick="deleteProduct(<?php $product_data['id'] ?>);">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

<?php

        }
    }
} else {
    echo ("1");
}

?>