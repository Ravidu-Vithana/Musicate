<?php

session_start();
require "connection.php";

$cart = Database::search("SELECT * FROM `cart` WHERE `user_email` = '" . $_SESSION["user"]["email"] . "'");
$cart_num = $cart->num_rows;

$userAddress = Database::search("SELECT * FROM `user_address` 
INNER JOIN `city_has_district` ON `city_has_district`.`city_has_district_id` = `user_address`.`city_has_district_id_id` 
INNER JOIN `district` ON `district`.`district_id` = `city_has_district`.`district_district_id` 
WHERE `user_email` = '" . $_SESSION["user"]["email"] . "'");
$userAddressData = $userAddress->fetch_assoc();

$total_qty = 0;
$total_price = 0;
$total_delivery = 0;
$total_discount = 0;

for ($x = 0; $x < $cart_num; $x++) {
    $cartData = $cart->fetch_assoc();

    $variant = Database::search("SELECT * FROM `variant` WHERE `id` = '" . $cartData["variant_id"] . "'");
    $variantData = $variant->fetch_assoc();

    if ($cartData["cart_qty"] > $variantData["qty"]) {
        Database::iud("UPDATE `cart` SET `cart_qty` = '" . $variantData["qty"] . "' WHERE `variant_id` = '" . $cartData["variant_id"] . "'");
    }

    $total_qty = $total_qty + $cartData["cart_qty"];
    $total_price = $total_price + ($variantData["price"] * $cartData["cart_qty"]);

    if($variantData["discount"] != 0){
        $total_discount = $total_discount + ($variantData["price"] * $variantData["discount"] / 100) * $cartData["cart_qty"];
    }

    if ($userAddressData["district_name"] == "Colombo") {
        $total_delivery = $total_delivery + ($variantData["delivery_fee_within_colombo"] * $cartData["cart_qty"]);
    } else {
        $total_delivery = $total_delivery + ($variantData["delivery_fee_outside_colombo"] * $cartData["cart_qty"]);
    }
}

$sub_total = $total_price + $total_delivery;

?>

<h3 class="fw-bold h3 text-secondary mt-3">Overview</h3>
<hr />
<div>
    <span class="fw-bold">No.of Item(s) :&nbsp;</span>
    <span><?php echo ($total_qty); ?> &nbsp;&rArr;&nbsp;&nbsp;Rs. <?php echo ($total_price); ?></span>
</div>
<div>
    <span class="fw-bold">Total Shipping :&nbsp;</span>
    <span>Rs. <?php echo ($total_delivery); ?></span>
</div>
<hr />
<div>
    <span class="fs-5 fw-bold">Sub-total :&nbsp;&nbsp;</span>
    <span class="fs-5">Rs. <?php echo ($sub_total); ?></span>
</div>
<div>
    <span class="fs-5 fw-bold">Total Discount :&nbsp;&nbsp;</span>
    <span class="fs-5">Rs. <?php echo ($total_discount); ?></span>
</div>
<div class="mt-2">
    <span class="fs-4 text-danger fw-bold">Total :&nbsp;&nbsp;</span>
    <span class="fs-4">Rs. <?php echo ($sub_total - $total_discount); ?></span>
</div>
<div class="col-12 d-grid mt-4 mb-3">
    <button class="btn btn-outline-success" onclick="checkoutCart();">Check Out</button>
</div>