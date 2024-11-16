<?php

require "connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./css/main.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Pacifico&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="icon" href="resources/logo_title.png" />

</head>

<body class="bg-secondary" onload="loadChartData();">

    <div class="container-fluid">
        <?php include "adminHeader.php"; ?>
        <div class="row">

            <div class="col-12 my-3">
                <div class="row">

                    <?php

                    $invoice = Database::search("SELECT * FROM `invoice`");

                    $d = new DateTime();
                    $tz = new DateTimeZone("Asia/Colombo");
                    $d->setTimezone($tz);
                    $thisYear = $d->format("Y");
                    $thisMonth = $d->format("m");
                    $today = $d->format("Y-m-d");

                    $sellingsToday = 0;
                    $monthlySellings = 0;
                    $yearlySellings = 0;

                    for ($i = 0; $i < $invoice->num_rows; $i++) {
                        $invoice_data = $invoice->fetch_assoc();
                        $dateTimeSplit = explode(" ", $invoice_data["order_date"]);
                        $dateSplit = explode("-", $dateTimeSplit[0]);
                        $year = $dateSplit[0];
                        $month = $dateSplit[1];
                        $day = $dateTimeSplit[0];

                        if ($month == $thisMonth) {
                            $monthlySellings++;
                        }
                        if ($year == $thisYear) {
                            $yearlySellings++;
                        }
                        if ($day == $today) {
                            $sellingsToday++;
                        }
                    }

                    ?>

                    <div class="col-10 offset-1 border border-primary border-2 border-opacity-25 rounded bg-body">
                        <ul class="nav nav-pills my-3 align-items-center" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="pill" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="manage-users-tab" data-bs-toggle="pill" data-bs-target="#manage-users" type="button" role="tab" aria-controls="manage-users" aria-selected="false">Manage Users</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="manage-products-tab" data-bs-toggle="pill" data-bs-target="#manage-products" type="button" role="tab" aria-controls="manage-products" aria-selected="false">Manage Products</button>
                            </li>
                            <li class="nav-item ms-1">
                                <a class="btn btn-outline-success" href="addProduct.php">+ New Product</a>
                            </li>
                        </ul>
                        <div class="tab-content w-auto" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 text-center py-2 bg-success bg-opacity-75 rounded">
                                            <span class="fw-bold fs-5">Sellings Today</span><br />
                                            <span><?php echo ($sellingsToday) ?></span>
                                        </div>
                                        <div class="col-4 text-center py-2 bg-primary bg-opacity-75 rounded">
                                            <span class="fw-bold fs-5">Monthly Sellings</span><br />
                                            <span><?php echo ($monthlySellings) ?></span>
                                        </div>
                                        <div class="col-4 text-center py-2 bg-warning bg-opacity-75 rounded">
                                            <span class="fw-bold fs-5">Yearly Sellings</span><br />
                                            <span><?php echo ($yearlySellings) ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex align-items-center justify-content-center my-2" id="chartArea">
                                            <div class="w-100 d-flex justify-content-center my-5" id="chartSpinner">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="row d-none" style="width: 100%;" id="chartDiv">
                                                <div class="col-6">
                                                    <canvas id="sellingsChart" class="align-self-center" style="width:100%;"></canvas>
                                                </div>
                                                <div class="col-6">
                                                    <canvas id="categoryChart" style="width:100%;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="manage-users" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                <div class="col-12">
                                    <div class="row justify-content-center">
                                        <div class="col-11">
                                            <?php

                                            $users = Database::search("SELECT * FROM `user` 
                                            INNER JOIN `gender` ON `user`.`gender_id` = `gender`.`id`
                                            ");
                                            $usersCount = $users->num_rows;

                                            ?>
                                            <div class="col-12 my-2">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" placeholder="Search Users..." id="userInput" onkeyup="searchUser();" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 bg-dark bg-opacity-10 rounded-2 p-2">
                                                <span class="fw-bold fs-4 text-center" style="color: rgb(161, 161, 161);">Total Number of Users = <?php echo ($usersCount); ?></span>
                                            </div>

                                            <div class="col-12 my-2 border border-2 border-dark border-opacity-25 rounded-2" style="height: 60vh; overflow-y: scroll; overflow-x: hidden;">
                                                <div class="row px-3 py-2 justify-content-center" id="userView">

                                                    <?php

                                                    if ($usersCount == 0) {
                                                    ?>

                                                        <div class="col-12 my-2">
                                                            <div class="row d-flex flex-row justify-content-evenly">
                                                                <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 40rem;">
                                                                <span class="noresultsText text-center">No Users Exist!</span>
                                                            </div>
                                                        </div>

                                                        <?php
                                                    } else {

                                                        for ($x = 0; $x < $usersCount; $x++) {
                                                            $userData = $users->fetch_assoc();

                                                            $joined_date = new DateTime($userData["joined_date"]);

                                                            $date = new DateTime();
                                                            $tz = new DateTimeZone("Asia/Colombo");
                                                            $date->setTimezone($tz);

                                                            $today = new DateTime($date->format("Y-m-d H:i:s"));
                                                            $difference = $today->diff($joined_date);


                                                        ?>
                                                            <!-- user card -->
                                                            <div class="card my-3" style="max-width: 50rem;">
                                                                <div class="row g-0 ps-2">
                                                                    <div class="col-lg-4 d-flex flex-column align-items-center justify-content-center">
                                                                        <?php

                                                                        $image_rs = Database::search("SELECT * FROM `profile_images` WHERE `user_email` = '" . $userData["email"] . "'");
                                                                        if ($image_rs->num_rows == 1) {
                                                                            $image_data = $image_rs->fetch_assoc();
                                                                        ?>

                                                                            <img src="<?php echo ($image_data["path"]); ?>" style="max-height: 10rem; max-width: 10rem;" class="img-fluid rounded" id="userImg<?php echo ($userData['email']); ?>" alt="..." onerror="userImageError('userImg<?php echo ($userData['email']); ?>','<?php echo ($userData['gender_name']); ?>');">

                                                                        <?php
                                                                        } else {
                                                                        ?>

                                                                            <img src="resources/<?php echo ($userData["gender_name"] == "Male" ? "userMale.jpg" : "userFemale.png"); ?>" style="max-height: 10rem; max-width: 10rem;" class="img-fluid rounded" alt="...">

                                                                        <?php
                                                                        }

                                                                        ?>
                                                                    </div>
                                                                    <div class="col-lg-8">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title"><?php echo ($userData["fname"] . " " . $userData["lname"]) ?></h5>
                                                                            <span class="text-black-50 fw-bold">User Email : </span><br />
                                                                            <span><?php echo ($userData["email"]) ?></span><br />
                                                                            <span class="text-black-50 fw-bold">Current Active Time : </span>
                                                                            <p>
                                                                                <?php

                                                                                echo ($difference->format('%Y') . " Years " . $difference->format('%m') . " Months " .
                                                                                    $difference->format('%d') . " Days " . $difference->format('%H') . " Hours " .
                                                                                    $difference->format('%i') . " Minutes ");

                                                                                ?>
                                                                            </p>
                                                                            <span id="blockText<?php echo ($userData["email"]) ?>" class="fw-bold text-<?php echo ($userData["status"] == 1 ? "success" : "danger"); ?>">User is <?php echo ($userData["status"] == 1 ? "Active" : "Blocked"); ?></span><br />
                                                                            <button id="blockBtn<?php echo ($userData["email"]) ?>" class="mt-2 btn btn-outline-<?php echo ($userData["status"] == 1 ? "danger" : "success"); ?>" onclick="userBlockStatus('<?php echo ($userData['email']); ?>');"><?php echo ($userData["status"] == 1 ? "Block" : "Unblock"); ?></button>
                                                                            <button class="mt-2 btn btn-outline-warning" onclick="viewBlockingHistory('<?php echo ($userData['email']); ?>');">View Blocking History</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- user card -->
                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="manage-products" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="col-12">
                                    <div class="row justify-content-center">
                                        <div class="col-12 mt-2">
                                            <div class="row justify-content-center">
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" placeholder="Search Products..." id="productInput" onkeyup="searchProduct();" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-11 my-2 border border-2 border-dark border-opacity-25" style="height: 60vh; overflow-y: scroll; overflow-x: hidden;">
                                            <div class="row gap-2 d-flex flex-row justify-content-center p-2" id="productView">

                                                <?php

                                                $product = Database::search("SELECT * FROM `product`");
                                                $product_num = $product->num_rows;

                                                if ($product_num == 0) {
                                                ?>

                                                    <div class="col-12 my-2">
                                                        <div class="row d-flex flex-row justify-content-evenly">
                                                            <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 40rem;">
                                                            <span class="noresultsText text-center">No Products Exist!</span>
                                                        </div>
                                                    </div>

                                                    <?php
                                                } else {
                                                    for ($y = 0; $y < $product_num; $y++) {

                                                        $product_data = $product->fetch_assoc();

                                                        $variant_rs = Database::search("SELECT * FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "'");
                                                        $variant_num = $variant_rs->num_rows;

                                                        $totalVariantQty = Database::search("SELECT SUM(qty) AS `total` FROM `variant` WHERE `product_id` = '" . $product_data["id"] . "'");
                                                        $totalVariantQtyData = $totalVariantQty->fetch_assoc();

                                                    ?>

                                                        <div class="card mb-3" style="max-width: 35rem;">
                                                            <div class="row g-0">
                                                                <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                                                                    <?php

                                                                    $cover_image_rs = Database::search("SELECT * FROM `cover_images` WHERE `product_id` = '" . $product_data["id"] . "'");
                                                                    $cover_image_num = $cover_image_rs->num_rows;

                                                                    if ($cover_image_num == 0) {
                                                                    ?>

                                                                        <img src="resources/no_image_available.jpg" class="img-fluid rounded" style="max-height: 10rem; max-width: 10rem;">

                                                                    <?php
                                                                    } else {
                                                                        $cover_image_data = $cover_image_rs->fetch_assoc();
                                                                    ?>

                                                                        <img src="<?php echo ($cover_image_data["path"]); ?>" class="img-fluid rounded" id="coverImg<?php echo ($product_data["id"]); ?>" style="max-height: 10rem; max-width: 10rem;" onerror="productImageError('coverImg<?php echo ($product_data['id']); ?>');">

                                                                    <?php
                                                                    }

                                                                    ?>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title"><?php echo ($product_data["title"]); ?></h5>
                                                                        <span class="card-text text-primary"><?php echo ($variant_num); ?> Variant(s)</span><br />
                                                                        <span class="card-text text-black-50 fw-bold">Total Quantity : <?php echo ($totalVariantQtyData["total"]); ?></span><br />
                                                                        <span class="card-text text-black-50 fw-bold">Product ID : <?php echo ($product_data["id"]); ?></span><br />
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox" role="switch" id="productAct<?php echo ($product_data["id"]); ?>" <?php if ($product_data["status"] == 1) { ?> checked <?php } ?> onclick="productBlockStatus('<?php echo ($product_data['id']); ?>');">
                                                                            <label class="form-check-label fw-bold text-<?php echo ($product_data["status"] == 1 ? "success" : "danger"); ?>" for="productAct<?php echo ($product_data["id"]); ?>" id="actDeactLabel<?php echo ($product_data["id"]); ?>">Product is <?php echo ($product_data["status"] == 1 ? "Active" : "Deactive"); ?></label>
                                                                        </div>
                                                                        <a class="btn btn-secondary mb-1" href="updateProduct.php?product_id=<?php echo ($product_data['id']); ?>">Update</a>
                                                                        <button class="btn btn-danger mb-1" onclick="deleteProduct(<?php echo ($product_data['id']); ?>);">Remove</button>
                                                                        <button class="btn btn-warning mb-1" onclick="viewProductBlockingHistory(<?php echo ($product_data['id']); ?>);">View Blocking History</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                <?php

                                                    }
                                                }

                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- user blocking modal -->
    <div class="modal fade" id="userBlockModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="fw-bold text-secondary">Please state the reason for blocking.</span><br />
                    <textarea id="reason" rows="6" class="form-control mt-2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="userBlockingProcess();">Block User</button>
                </div>
            </div>
        </div>
    </div>
    <!-- user blocking modal -->

    <!-- user blocking history modal -->
    <div class="modal fade" id="userBlockHistoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fw-bold text-primary fs-5">Blocking History</span><br />
                </div>
                <div class="modal-body">
                    <div class="col-12 px-2" id="blockingHistoryView">
                        <div class="d-flex justify-content-center my-5">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
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
    <!-- user blocking history modal -->

    <!-- product blocking modal -->
    <div class="modal fade" id="productBlockModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="fw-bold text-secondary">Please state the reason for deactivating.</span><br />
                    <textarea id="reasonProduct" rows="6" class="form-control mt-2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="toggleCheck();">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="productBlockingProcess();">Deactivate</button>
                </div>
            </div>
        </div>
    </div>
    <!-- product blocking modal -->

    <!-- product blocking history modal -->
    <div class="modal fade" id="productBlockHistoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fw-bold text-primary fs-5">Blocking History</span><br />
                </div>
                <div class="modal-body">
                    <div class="col-12 px-2" id="productBlockingHistoryView">
                        <div class="d-flex justify-content-center my-5">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
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
    <!-- product blocking history modal -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="script.js"></script>
</body>

</html>