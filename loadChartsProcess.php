<?php

require "connection.php";

$responseArray = array();

$category = Database::search("SELECT * FROM `category`");

$days = array();
$daysQty = array();
$categories = array();
$categoriesQty = array();
$categoryIDS = array();
$categoryCount = 0;

for($x3 = 0; $x3 < 7; $x3++){
    $daysQty[$x3] = 0;
}

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);

for ($x = 0; $x < 7; $x++) {
    $days[$x] = date('Y-m-d', strtotime("-".$x." days"));
}

for($y = 0; $y < $category->num_rows; $y++){
    $category_data = $category->fetch_assoc();
    $categoryIDS[$y] = $category_data["id"];
    $categoriesQty[$y] = 0;
    $categories[$y] = $category_data["category_name"];
    $categoryCount++;
}

$invoice = Database::search("SELECT * FROM `invoice`");

for ($i = 0; $i < $invoice->num_rows; $i++) {
    $invoice_data = $invoice->fetch_assoc();
    $dateTimeSplit = explode(" ", $invoice_data["order_date"]);
    
    for ($x2 = 0; $x2 < 7; $x2++) {
        if ($dateTimeSplit[0] == $days[$x2]) {
            $items = Database::search("SELECT SUM(`inv_qty`) AS `total_qty` FROM `items` WHERE `invoice_id`='".$invoice_data["inv_id"]."'");
            $items_data = $items->fetch_assoc();
            $daysQty[$x2] = (int)$daysQty[$x2] + (int)$items_data["total_qty"];
        }
    }
}

$products = Database::search("SELECT * FROM `invoice` 
INNER JOIN `items` ON `items`.`invoice_id` = `invoice`.`inv_id` 
INNER JOIN `variant` ON `variant`.`id` = `items`.`variant_id` 
INNER JOIN `product` ON `product`.`id` = `variant`.`product_id` 
INNER JOIN `brand_has_category` ON `brand_has_category`.`id` = `product`.`brand_has_category_id` 
INNER JOIN `category` ON `category`.`id` = `brand_has_category`.`category_id`");

for($z = 0; $z < $products->num_rows; $z++){
    $products_data = $products->fetch_assoc();

    for($cat = 0; $cat < $categoryCount; $cat++){
        if($products_data["category_id"] == $categoryIDS[$cat]){
            $categoriesQty[$cat] = (int)$categoriesQty[$cat] + (int)$products_data["inv_qty"];
        }
    }

}

$responseArray["days"] = $days;
$responseArray["daysQty"] = $daysQty;
$responseArray["categories"] = $categories;
$responseArray["categoriesQty"] = $categoriesQty;
$responseArray["categoryIDS"] = $categoryIDS;
$responseArray["categoryCount"] = $categoryCount;

echo(json_encode($responseArray));