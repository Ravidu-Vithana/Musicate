<?php

session_start();
require "connection.php";

if (isset($_GET["inv_id"])) {

    $invoice = Database::search("SELECT * FROM `invoice` 
            INNER JOIN `items` ON `items`.`invoice_id` = `invoice`.`inv_id` 
            INNER JOIN `variant` ON `variant`.`id` = `items`.`variant_id` 
            INNER JOIN `product` ON `product`.`id` = `variant`.`product_id` 
            INNER JOIN `condition` ON `variant`.`condition_id` = `condition`.`id` 
            WHERE `inv_id` = '" . $_GET["inv_id"] . "'");

    for ($x = 1; $x <= $invoice->num_rows; $x++) {
        $invoice_data = $invoice->fetch_assoc();

        $reviews = Database::search("SELECT * FROM `product_reviews` WHERE `item_id` = '" . $invoice_data["item_id"] . "'");

?>
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="./resources/signinupBg2.jpg" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo ($invoice_data["title"]) ?></h5>
                        <h5 class="card-title text-secondaryM fs-6"><?php echo ($invoice_data["variant_title"]) ?></h5>
                        <span class="card-text">Price: </span>
                        <span class="card-text">Rs.<?php echo ($invoice_data["buying_price"]) ?></span><br>
                        <span class="card-text">Discount: </span>
                        <span class="card-text"><?php echo ($invoice_data["discount_given"]) ?>%</span><br>
                        <span class="card-text">Delivery Fee: </span>
                        <span class="card-text">Rs.<?php echo ($invoice_data["buying_del_fee"]) ?></span><br>
                        <button class="btn btn-outline-danger w-100" type="button" data-bs-toggle="collapse" data-bs-target="#reviewCollapse<?php echo ($x) ?>" aria-expanded="false" aria-controls="reviewCollapse<?php echo ($x) ?>">
                            Review
                        </button>
                        <div class="collapse" id="reviewCollapse<?php echo ($x) ?>">

                            <?php

                            if ($reviews->num_rows == 1) {
                                $reviews_data = $reviews->fetch_assoc();

                            ?>

                                <div class="card card-body">
                                    <div class="w-100 d-flex justify-content-center gap-1">

                                        <?php

                                        for ($x = 1; $x <= 5; $x++) {
                                            if ($x <= $reviews_data["star_count"]) {
                                        ?>
                                                <i class="bi bi-star-fill text-warning" id="reviewStar<?php echo ($x) ?>" onclick="fillReviewStars('<?php echo ($x) ?>');"></i>
                                            <?php
                                            } else {
                                            ?>
                                                <i class="bi bi-star text-warning" id="reviewStar<?php echo ($x) ?>" onclick="fillReviewStars('<?php echo ($x) ?>');"></i>
                                        <?php
                                            }
                                        }

                                        ?>
                                    </div>
                                    <textarea id="reviewComment" class="w-100 form-control" rows="3"><?php echo($reviews_data["description"]) ?></textarea>
                                    <button class="btn btn-outline-success w-100 my-2" onclick="reviewPurchase('<?php echo ($invoice_data['item_id']) ?>')">Save</button>
                                </div>

                            <?php

                            } else {

                            ?>

                                <div class="card card-body">
                                    <div class="w-100 d-flex justify-content-center gap-1">
                                        <i class="bi bi-star text-warning" id="reviewStar1" onclick="fillReviewStars('1');"></i>
                                        <i class="bi bi-star text-warning" id="reviewStar2" onclick="fillReviewStars('2');"></i>
                                        <i class="bi bi-star text-warning" id="reviewStar3" onclick="fillReviewStars('3');"></i>
                                        <i class="bi bi-star text-warning" id="reviewStar4" onclick="fillReviewStars('4');"></i>
                                        <i class="bi bi-star text-warning" id="reviewStar5" onclick="fillReviewStars('5');"></i>
                                    </div>
                                    <textarea id="reviewComment" class="w-100 form-control" rows="3"></textarea>
                                    <button class="btn btn-outline-success w-100 my-2" onclick="reviewPurchase('<?php echo ($invoice_data['item_id']) ?>')">Save</button>
                                </div>

                            <?php

                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php

    }
} else {
    echo ("1");
}
