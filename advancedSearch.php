<?php

require "connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Search | Musicate</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./css/main.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Pacifico&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="icon" href="resources/logo_title.png" />

</head>

<body>

    <div class="container-fluid">
        <?php include "userHeader.php"; ?>
        <div class="row">

            <div class="col-12 my-2">
                <div class="row">
                    <div class="col-12 my-2 text-center">
                        <h1 class="h1 title text-danger">Advanced Search</h1>
                    </div>
                    <div class="col-12">
                        <hr class="border-redM" />
                    </div>
                    <div class="col-12 col-lg-8 offset-lg-2">
                        <div class="row">
                            <div class=" col-12 col-md-8 col-lg-10 mt-2 mb-1">
                                <input type="text" class="form-control" placeholder="Type Keyword To Search..." id="input" />
                            </div>
                            <div class="col-12 col-md-4 col-lg-2 mt-2 mb-1 d-grid">
                                <button class="btn btn-danger" onclick="advancedSearch();">Search</button>
                            </div>
                            <div class=" col-12">
                                <hr class="border-redM" />
                            </div>
                        </div>
                    </div>

                    <div class="offset-md-1 col-12 col-md-10 mt-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-4 mt-2 d-flex flex-column bg-danger bg-opacity-10 rounded py-2">
                                        <span class="text-danger text-center fw-bold fs-5">Category</span>
                                        <?php

                                        $category_rs = Database::search("SELECT * FROM `category`");
                                        $category_num = $category_rs->num_rows;

                                        ?>

                                        <select class="form-select" id="cat">
                                            <option value="0">Select Category</option>

                                            <?php

                                            for ($x = 0; $x < $category_num; $x++) {

                                                $category_data = $category_rs->fetch_assoc();

                                            ?>

                                                <option value="<?php echo ($category_data["id"]); ?>"><?php echo ($category_data["category_name"]); ?></option>

                                            <?php

                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 d-flex flex-column bg-danger bg-opacity-10 rounded py-2">
                                        <span class="text-danger text-center fw-bold fs-5">Brand</span>
                                        <?php

                                        $brand_rs = Database::search("SELECT * FROM `brand` ORDER BY `brand_name` ASC");
                                        $brand_num = $brand_rs->num_rows;

                                        ?>

                                        <select class="form-select" onchange="loadModel();" id="b">
                                            <option value="0">Select Brand</option>

                                            <?php

                                            for ($y = 0; $y < $brand_num; $y++) {

                                                $brand_data = $brand_rs->fetch_assoc();

                                            ?>

                                                <option value="<?php echo ($brand_data["id"]); ?>"><?php echo ($brand_data["brand_name"]); ?></option>

                                            <?php

                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 d-flex flex-column bg-danger bg-opacity-10 rounded py-2">
                                        <span class="text-danger text-center fw-bold fs-5">Model</span>
                                        <select class="form-select" id="m">
                                            <option value="0">Select Brand First</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 d-flex flex-column bg-danger bg-opacity-10 rounded py-2">
                                        <span class="text-danger text-center fw-bold fs-5">Price From</span>
                                        <input type="text" class="form-control" placeholder="Price from..." id="pfrm" />
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 d-flex flex-column bg-danger bg-opacity-10 rounded py-2">
                                        <span class="text-danger text-center fw-bold fs-5">Price To</span>
                                        <input type="text" class="form-control" placeholder="Price to..." id="pto" />
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 d-flex flex-column bg-danger bg-opacity-10 rounded py-2">
                                        <span class="text-danger text-center fw-bold fs-5">Condition</span>

                                        <?php

                                        $condition_rs = Database::search("SELECT * FROM `condition`");
                                        $condition_num = $condition_rs->num_rows;

                                        ?>

                                        <select class="form-select" id="con">
                                            <option value="0">Select Condition</option>

                                            <?php

                                            for ($z = 0; $z < $condition_num; $z++) {
                                                $condition_data = $condition_rs->fetch_assoc();

                                            ?>

                                                <option value="<?php echo ($condition_data["id"]); ?>"><?php echo ($condition_data["condition_name"]); ?></option>

                                            <?php

                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 d-flex flex-column bg-danger bg-opacity-10 rounded py-2">
                                        <span class="text-danger text-center fw-bold fs-5">Sort By</span>
                                        <select class="form-select" id="sort">
                                            <option value="0">Select</option>
                                            <option value="1">Price Low To High</option>
                                            <option value="2">Price High To Low</option>
                                            <option value="3">Quantity Low To High</option>
                                            <option value="4">Quantity High To Low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-center">
                        <div class="col-10 mt-2 rounded bg-body border border-danger border-4 border-opacity-10 ">
                            <div class="row justify-content-evenly gap-4 py-4" id="mainView">
                                <div class="d-flex flex-column w-100 align-items-center gap-2">
                                    <span class="fw-bold text-black-50"><i class="bi bi-search" style="font-size: 120px;"></i></span>
                                    <span class="h2 text-black-50 fw-bold">No Items Searched Yet...</span>
                                </div>
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