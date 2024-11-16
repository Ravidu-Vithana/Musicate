<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart | Musicate</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="./css/main.min.css">

        <link rel="icon" href="resources/logo_title.png" />

    </head>

    <body onload="loadCartSummary();">

        <div class="container-fluid">
            <?php include "userHeader.php";

            $cartHasItems = false;
            $cart = Database::search("SELECT * FROM `cart` 
                                        INNER JOIN `variant` ON `variant`.`id` = `cart`.`variant_id` 
                                        INNER JOIN `product` ON `product`.`id` = `variant`.`product_id` 
                                        INNER JOIN `condition` ON `variant`.`condition_id` = `condition`.`id` 
                                        INNER JOIN `user_address` ON `user_address`.`user_email` = `cart`.`user_email` 
                                        INNER JOIN `city_has_district` ON `city_has_district`.`city_has_district_id` = `user_address`.`city_has_district_id_id` 
                                        INNER JOIN `district` ON `district`.`district_id` = `city_has_district`.`district_district_id` 
                                        WHERE `cart`.`user_email` = '" . $_SESSION["user"]["email"] . "' AND `status` = '1'");

            ?>
            <div class="row min-vh-100">

                <div class="col-12">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center py-5" style="background-image: url(./resources/cartBg.jpg); background-size: cover; background-position: center;">
                            <h1 class="h1 d-flex align-items-center title text-white">
                                Cart
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white" style="height: 3rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </h1>
                        </div>
                    </div>
                    <div class="row py-4 justify-content-center">
                        <div class="col-12 col-md-10 col-lg-9 d-flex flex-column align-items-center">
                            <table class="table <?php if ($cart->num_rows != 0){ ?>table-hover <?php } ?>align-middle d-none d-lg-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Price Per Unit</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Delivery Fee</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <!-- ROWS -->

                                    <?php

                                    if ($cart->num_rows == 0) {
                                    ?>

                                        <tr>
                                            <td colspan="5">
                                                <div class="col-12 my-2">
                                                    <div class="row d-flex flex-row justify-content-evenly">
                                                        <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 30rem;">
                                                        <span class="noresultsText text-center">No items in your cart yet!</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php
                                    } else {
                                        $cartHasItems = true;

                                        $y = 0;
                                        foreach ($cart as $cartData) {

                                        ?>

                                            <tr>
                                                <td class="d-flex align-items-center gap-3" onclick="window.location='singleProductView.php?product_id=<?php echo ($cartData['product_id']); ?>'">

                                                    <img src="<?php echo ($cartData["image_path"]); ?>" class="img-fluid rounded" style="max-height: 7rem;" id="img<?php echo ($y); ?>" onerror="productImageError('img<?php echo ($y) ?>')" />
                                                    <div class="d-flex flex-column gap-1">
                                                        <span><?php echo ($cartData["title"]); ?></span>
                                                        <span class="text-secondaryM"><?php echo ($cartData["variant_title"]); ?></span>
                                                    </div>
                                                </td>
                                                <td>Rs. <?php echo ($cartData["price"]); ?></td>
                                                <td>
                                                    <i class="bi bi-dash-square fs-5" style="cursor: pointer;" onclick="quantityChange('<?php echo ($cartData['variant_id']); ?>','-1');"></i>&nbsp;&nbsp;
                                                    <span id="selectedQty<?php echo ($cartData['variant_id']); ?>" class="card-text fs-5 text-decoration-underline"><?php echo ($cartData["cart_qty"]); ?></span>&nbsp;&nbsp;
                                                    <i class="bi bi-plus-square fs-5" style="cursor: pointer;" onclick="quantityChange('<?php echo ($cartData['variant_id']); ?>','+1');"></i><br />
                                                </td>
                                                <td><?php echo ($cartData["discount"]); ?>%</td>
                                                <?php

                                                if ($cartData["district_name"] == "Colombo") {
                                                ?>

                                                    <td>Rs. <?php echo ($cartData["delivery_fee_within_colombo"]); ?></td>

                                                <?php
                                                } else {
                                                ?>

                                                    <td>Rs. <?php echo ($cartData["delivery_fee_outside_colombo"]); ?></td>

                                                <?php
                                                }

                                                ?>
                                                <td>
                                                    <a onclick="removeFromCart('<?php echo ($cartData['cart_id']) ?>');">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 2rem; cursor: pointer;">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>

                                    <?php
                                            $y++;
                                        }
                                    }

                                    ?>
                                    <!-- ROWS -->
                                </tbody>
                            </table>
                            <div class="d-lg-none col-12 gap-1 d-flex flex-column align-items-center">

                                <?php
                                $y = 0;
                                foreach ($cart as $cartData) {

                                ?>

                                    <div class="card mb-3 position-relative" style="max-width: 40rem;">
                                        <a onclick="removeFromCart('<?php echo ($cartData['cart_id']) ?>');" class="position-absolute top-0 end-0 text-secondaryM">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 2rem; cursor: pointer;">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="<?php echo ($cartData["image_path"]); ?>" class="img-fluid rounded-start" id="img<?php echo ($y); ?>" onerror="productImageError('img<?php echo ($y) ?>')" />
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo ($cartData["title"]); ?></h5>
                                                    <h5 class="card-title text-secondaryM fs-6"><?php echo ($cartData["variant_title"]); ?></h5>
                                                    <span class="card-text">Price: </span>
                                                    <span class="card-text">Rs. <?php echo ($cartData["price"]); ?></span><br>
                                                    <span class="card-text">Discount: </span>
                                                    <span class="card-text"><?php echo ($cartData["discount"]); ?>%</span><br>
                                                    <span class="card-text">Delivery Fee: </span>
                                                    <?php

                                                    if ($cartData["district_name"] == "Colombo") {
                                                    ?>

                                                        <span><?php echo ($cartData["delivery_fee_within_colombo"]); ?></span><br>

                                                    <?php
                                                    } else {
                                                    ?>

                                                        <span><?php echo ($cartData["delivery_fee_outside_colombo"]); ?></span><br>

                                                    <?php
                                                    }

                                                    ?>
                                                    <i class="bi bi-dash-square fs-5" style="cursor: pointer;" onclick="quantityChange('<?php echo ($cartData['variant_id']); ?>','-1');"></i>&nbsp;&nbsp;
                                                    <span id="selectedQty<?php echo ($cartData['variant_id']); ?>" class="card-text fs-5 text-decoration-underline"><?php echo ($cartData["cart_qty"]); ?></span>&nbsp;&nbsp;
                                                    <i class="bi bi-plus-square fs-5" style="cursor: pointer;" onclick="quantityChange('<?php echo ($cartData['variant_id']); ?>','+1');"></i><br />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                    $y++;
                                }

                                ?>

                            </div>
                        </div>

                        <?php

                        if ($cartHasItems) {

                        ?>

                            <div class="col-12 col-md-10 col-lg-9">
                                <div class="row border border-3">
                                    <div class="col-12" id="summaryView">
                                        <div class="d-flex justify-content-center my-5">
                                            <div class="spinner-border" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php

                        }

                        ?>
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
} else {
    header("Location:signin.php");
}

?>