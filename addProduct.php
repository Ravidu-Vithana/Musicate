<?php

require "connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Musicate</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="./css/main.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Pacifico&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="icon" href="resources/logo_title.png" />

</head>

<body onload="variantSession();">

    <div class="container-fluid">
        <div class="row">
            <?php include "adminHeader.php"; ?>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 text-center text-white bg-dark bg-opacity-75 py-3">
                        <h3 class="h3 title">Add Product</h3>
                    </div>
                    <div class="col-12 bg-dark bg-opacity-10">
                        <div class="row">
                            <div class="col-12 col-md-4 text-center mt-2">
                                <label class="form-label fw-bold fs-5">Category</label><br />
                                <span id="errcat"></span>
                                <select class="form-select mb-2" id="cat" onchange="loadSub();">
                                    <option value="0">Select Category</option>
                                    <?php
                                    $category_rs = Database::search("SELECT * FROM `category`");
                                    $category_num = $category_rs->num_rows;

                                    for ($x = 0; $x < $category_num; $x++) {

                                        $category_data = $category_rs->fetch_assoc();

                                    ?>

                                        <option value="<?php echo ($category_data["id"]); ?>"><?php echo ($category_data["category_name"]); ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Add New Category" id="addCat">
                                    <button class="btn btn-outline-secondary" type="button" onclick="addCategory();">+ Add</button>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 text-center mt-2">
                                <label class="form-label fw-bold fs-5">Sub-category</label><br />
                                <span id="errsubc"></span>
                                <select class="form-select mb-2" id="subc" onchange="loadBrand();">
                                    <option value="0">Select category first</option>
                                </select>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Add New Sub-category" id="addSubCat">
                                    <button class="btn btn-outline-secondary" type="button" onclick="addSubCat();">+ Add</button>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 text-center mt-2">
                                <label class="form-label fw-bold fs-5">Brand</label><br />
                                <span id="errb"></span>
                                <select class="form-select mb-2" id="b" onchange="loadModel();">
                                    <option value="0">Select sub-category first</option>
                                </select>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Add New Brand" id="addb">
                                    <button class="btn btn-outline-secondary" type="button" onclick="addBrand();">+ Add</button>
                                </div>
                            </div>
                            <div class="col-12 d-none d-md-block">
                                <hr style="border-width: 3px;" />
                            </div>
                            <div class="col-12 col-md-4 text-center mt-2">
                                <label class="form-label fw-bold fs-5">Model</label><br />
                                <span id="errm"></span>
                                <select class="form-select mb-2" id="m">
                                    <option value="0">Select brand first</option>
                                </select>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Add New Model" id="addm">
                                    <button class="btn btn-outline-secondary" type="button" onclick="addModel();">+ Add</button>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mt-2 text-center">
                                <label class="form-label fw-bold fs-5 ">Product Title</label>
                                <div class="form-check my-2 text-start">
                                    <input class="form-check-input" type="checkbox" id="addmodelname" onclick="sameAsModel();">
                                    <label class="form-check-label" for="addmodelname">
                                        Same as Brand + Model Name
                                    </label>
                                </div>
                                <input class="form-control" type="text" id="title" />
                            </div>
                            <div class="col-12 col-md-4 mt-2">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <label class="form-label fw-bold fs-5">Product Cover Images</label><br />
                                        <span>(Maximum 5 images)</span><br/>
                                        <span ><i style="font-size: 12px;">only jpg, jpeg, png and svg files allowed*</i></span>
                                    </div>
                                    <div class="col-12">
                                        <div class="row d-flex flex-row justify-content-center">
                                            <div class="col-4 border border-success rounded d-flex flex-column align-items-center">
                                                <img src="resources/addproductimg.svg" class="img-fluid" style="max-width: 100px;" id="i0" onerror="productImageError('i0')" />
                                            </div>
                                            <div class="col-4 border border-success rounded d-flex flex-column align-items-center">
                                                <img src="resources/addproductimg.svg" class="img-fluid" style="max-width: 100px;" id="i1" onerror="productImageError('i1')" />
                                            </div>
                                            <div class="col-4 border border-success rounded d-flex flex-column align-items-center">
                                                <img src="resources/addproductimg.svg" class="img-fluid" style="max-width: 100px;" id="i2" onerror="productImageError('i2')" />
                                            </div>
                                            <div class="col-4 border border-success rounded d-flex flex-column align-items-center">
                                                <img src="resources/addproductimg.svg" class="img-fluid" style="max-width: 100px;" id="i3" onerror="productImageError('i3')" />
                                            </div>
                                            <div class="col-4 border border-success rounded d-flex flex-column align-items-center">
                                                <img src="resources/addproductimg.svg" class="img-fluid" style="max-width: 100px;" id="i4" onerror="productImageError('i4')" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="offset-lg-3 col-12 col-lg-6 d-grid my-3">
                                        <input type="file" class="d-none" id="cImage" name="cImage" multiple />
                                        <label for="cImage" class="btn btn-outline-primary fw-bold" onclick="coverImages();">Upload Images</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-dark bg-dark bg-opacity-25 py-3">
                                <h5 class="h5 title my-auto">Add Product Variants</h5>
                            </div>

                            <!-- variant div -->
                            <div class="col-12 px-4" id="variantDiv"></div>
                            <!-- variant div -->

                            <div class="col-12">
                                <div class="row" id="removeBtnDiv" style="display: none;">
                                    <div class="col-12 text-center mt-3">
                                        
                                        <button class="btn btn-danger fw-bold text-white" onclick="removeVariant();" id="removeBtn"><i class="bi bi-trash-fill"></i></button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center mt-3">
                                        <button class="btn btn-outline-dark fw-bold" onclick="newVariant();"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;New Variant</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr style="border-width: 3px;" />
                            </div>
                            <div class="col-12 col-md-4 offset-md-4 d-grid mb-3">
                                <button class="btn btn-outline-success fw-bold" id="addProductBtn" onclick="addProduct();">Add Product</button>
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