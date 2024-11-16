<?php

require "connection.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./css/main.min.css">

    <link rel="icon" href="resources/logo_title.png" />

</head>

<body>

    <div class="container-fluid">
        <?php include "userHeader.php"; ?>
        <div class="row">
            <div class="col-12 mt-2">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 d-flex justify-content-center" style="background-image: url(./resources/purchaseHistoryBg.jpg); background-size: cover; background-position: center; padding-top: 4rem; padding-bottom: 4rem;">
                        <h1 class="h1 d-flex align-items-center title text-white">
                            Purchase History
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white" style="height: 3rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </h1>
                    </div>
                    <div class="col-12 col-md-10 col-lg-9 d-flex flex-column align-items-center my-3">
                        <table class="table table-hover align-middle d-none d-lg-table">
                            <thead>
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Total Item Count</th>
                                    <th scope="col">Discount Received</th>
                                    <th scope="col">Paid Amount</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <!-- ROWS -->

                                <?php

                                $invoice =  Database::search("SELECT * FROM `invoice` WHERE `user_email` = '" . $_SESSION["user"]["email"] . "'");

                                if ($invoice->num_rows == 0) {

                                ?>

                                    <tr>
                                        <td colspan="5">
                                            <div class="col-12 my-2">
                                                <div class="row d-flex flex-row justify-content-evenly">
                                                    <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 30rem;">
                                                    <span class="noresultsText text-center">No items purchased yet!</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                } else {

                                    for ($y = 0; $y < $invoice->num_rows; $y++) {

                                        $invoice_data = $invoice->fetch_assoc();

                                        $invoiceItems = Database::search("SELECT * FROM `items` 
                                        WHERE `items`.`invoice_id` = '" . $invoice_data["inv_id"] . "'");

                                        $itemCount = $invoiceItems->num_rows;

                                        $totalDiscount = 0;
                                        $paidAmount = 0;

                                        foreach ($invoiceItems as $invoiceItemsData) {
                                            $totalDiscount += $invoiceItemsData["discount_given"] * $invoiceItemsData["inv_qty"];
                                            $paidAmount += $invoiceItemsData["buying_price"] * $invoiceItemsData["inv_qty"];
                                        }

                                    ?>

                                        <tr>
                                            <td>
                                                <?php echo ($invoice_data["inv_id"]) ?>
                                            </td>
                                            <td>
                                                <?php echo ($invoice_data["order_date"]) ?>
                                            </td>
                                            <td>
                                                <?php echo ($itemCount) ?>
                                            </td>
                                            <td>Rs. <?php echo ($totalDiscount) ?></td>
                                            <td>
                                                Rs. <?php echo ($paidAmount) ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-success" onclick="viewPurchaseDetails('<?php echo ($invoice_data['inv_id']) ?>','<?php echo ($invoice_data['order_date']) ?>');">View Invoice</button>
                                                <button class="btn btn-outline-danger" onclick="viewPurchaseDetails('<?php echo ($invoice_data['inv_id']) ?>');">View Details</button>
                                            </td>
                                        </tr>

                                <?php
                                    }
                                }

                                ?>
                                <!-- ROWS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php include "footer.php"; ?>
        </div>
    </div>

    <!-- MORE DETAILS MODAL -->
    <div class="modal fade" id="moreDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">More Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="moreDetailsView">
                    <!-- Item details -->
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="./resources/signinupBg2.jpg" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Something</h5>
                                    <h5 class="card-title text-secondaryM fs-6">Sub title</h5>
                                    <span class="card-text">Price: </span>
                                    <span class="card-text">Rs.150000</span><br>
                                    <span class="card-text">Discount: </span>
                                    <span class="card-text">6%</span><br>
                                    <span class="card-text">Delivery Fee: </span>
                                    <span class="card-text">Rs.2000</span><br>
                                    <button class="btn btn-outline-danger w-100" type="button" data-bs-toggle="collapse" data-bs-target="#reviewCollapse" aria-expanded="false" aria-controls="reviewCollapse">
                                        Review
                                    </button>
                                    <div class="collapse" id="reviewCollapse">
                                        <div class="card card-body">
                                            <div class="w-100 d-flex justify-content-center gap-1">
                                                <i class="bi bi-star text-warning" id="reviewStar1" onclick="fillReviewStars('1');"></i>
                                                <i class="bi bi-star text-warning" id="reviewStar2" onclick="fillReviewStars('2');"></i>
                                                <i class="bi bi-star text-warning" id="reviewStar3" onclick="fillReviewStars('3');"></i>
                                                <i class="bi bi-star text-warning" id="reviewStar4" onclick="fillReviewStars('4');"></i>
                                                <i class="bi bi-star text-warning" id="reviewStar5" onclick="fillReviewStars('5');"></i>
                                            </div>
                                            <textarea id="reviewComment" class="w-100 form-control" rows="3"></textarea>
                                            <button class="btn btn-outline-success w-100 my-2" onclick="reviewPurchase('1')">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MORE DETAILS MODAL -->

    <script src="script.js"></script>
</body>

</html>