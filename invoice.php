<?php

session_start();
require "connection.php";

if (isset($_POST["orderObject"]) && isset($_POST["isCart"])) {

    $orderObject = json_decode($_POST["orderObject"], true);
    $isCart;
    if ($_POST["isCart"] == "true") {
        $isCart = true;
    } else {
        $isCart = false;
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Invoice</title>

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
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <button class="btn btn-danger" onclick="printInvoice()">
                                Print Invoice
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height: 2rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="row justify-content-center" id="invoice">
                        <div class="col-11 col-md-10 border border-primary border-2 border-opacity-25 my-3">
                            <div class="d-flex flex-column">
                                <div class="w-100 d-flex flex-column align-items-center mt-2">
                                    <img src="resources/logo.png" class="rounded-circle" style="height: 100px;" />
                                </div>
                                <div class="w-100 mt-2 text-center border-bottom border-primary border-opacity-25 border-2">
                                    <h1 class="h1 text-primary">Invoice</h1>
                                </div>
                                <div class="d-flex align-items-center justify-content-between border-bottom border-primary border-opacity-25 border-2 p-2">
                                    <div>
                                        <span class="fw-bold">Customer Name : </span>
                                        <span><?php echo ($orderObject["firstname"] . " " . $orderObject["lastname"]) ?></span><br />
                                        <span class="fw-bold">Order ID : </span>
                                        <span><?php echo ($orderObject["orderID"]) ?></span><br />
                                        <span class="fw-bold">Date : </span>
                                        <span><?php echo ($orderObject["datetime"]) ?></span><br />
                                    </div>
                                    <div>
                                        <span class="fw-bold fs-3">Musicate</span><br />
                                        <span>Kurunegala, Sri Lanka</span><br />
                                        <span>+94112 777999</span><br />
                                        <span>musicate.support@gmail.com</span>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-primary mt-4">
                                        <thead class="table-light border-primary text-center">
                                            <tr>
                                                <th scope="col" class="fs-5">#</th>
                                                <th scope="col" class="fs-5">Product</th>
                                                <th scope="col" class="fs-5">Unit Price</th>
                                                <th scope="col" class="fs-5">Qty</th>
                                                <th scope="col" class="fs-5">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if ($isCart) {

                                                for ($x = 1; $x <= $orderObject["itemCount"]; $x++) {
                                            ?>

                                                    <tr>
                                                        <th scope="row" class="text-center"><?php echo ($x) ?></th>
                                                        <td><?php echo ($orderObject["item_name_" . $x]); ?></td>
                                                        <td class="text-end"><?php echo ($orderObject["amount_" . $x]); ?></td>
                                                        <td class="text-end"><?php echo ($orderObject["quantity_" . $x]); ?></td>
                                                        <td class="text-end"><?php echo ((int)$orderObject["amount_" . $x] * (int)$orderObject["quantity_" . $x]); ?></td>
                                                    </tr>

                                                <?php
                                                }
                                            } else {
                                                ?>

                                                <tr>
                                                    <th scope="row" class="text-center">1</th>
                                                    <td><?php echo ($orderObject["items"]); ?></td>
                                                    <td class="text-end"><?php echo ($orderObject["amount_1"]); ?></td>
                                                    <td class="text-end"><?php echo ($orderObject["quantity_1"]); ?></td>
                                                    <td class="text-end"><?php echo ((int)$orderObject["quantity_1"] * (int)$orderObject["amount_1"]); ?></td>
                                                </tr>

                                            <?php
                                            }

                                            ?>
                                            <tr>
                                                <td colspan="4" class="text-end">Total Delivery Charges</td>
                                                <td class="text-end"><?php echo ($orderObject["totalDelivery"]); ?></td>
                                            </tr>
                                            <tr class="table-light border-primary">
                                                <th scope="row" colspan="4" class="text-end">Sub-total</th>
                                                <td class="text-end fw-bold"><?php echo ((int)$orderObject["amount"] + (int)$orderObject["totalDiscount"]); ?></td>
                                            </tr>
                                            <tr class="table-light border-primary">
                                                <th scope="row" colspan="4" class="text-end">Discount</th>
                                                <td class="text-end fw-bold"><?php echo ($orderObject["totalDiscount"]); ?></td>
                                            </tr>
                                            <tr class="table-light border-primary">
                                                <th scope="row" colspan="4" class="text-end fs-5">Grand Total</th>
                                                <td class="text-end fs-5 fw-bold"><?php echo ($orderObject["amount"]); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex flex-column flex-md-row gap-2 gap-md-0 justify-content-between p-2">
                                    <span style="font-size: 12px;">Computer Generated Invoive. No Signature or Seal required</span>
                                    <span style="font-size: 12px;">Returning is applicable for only 7 Days</span>
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
    header("Location: index.php");
}

?>