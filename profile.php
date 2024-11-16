<?php

session_start();

if (isset($_SESSION["user"])) {

?>

    <!DOCTYPE html>
    <html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Profile</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="./css/main.min.css">

        <link rel="icon" href="resources/logo_title.png" />

    </head>

    <body>

        <div class="container-fluid">
            <?php include "userHeader.php"; ?>
            <div class="row">

                <?php

                require "connection.php";

                $email = $_SESSION["user"]["email"];

                $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON user.gender_id=gender.id
                WHERE `email`='" . $email . "'");
                $user_data = $user_rs->fetch_assoc();

                $image_rs = Database::search("SELECT * FROM `profile_images` WHERE `user_email`='" . $email . "'");
                $image_num = $image_rs->num_rows;
                $image_data = $image_rs->fetch_assoc();

                $user_address_rs = Database::search("SELECT * FROM `user` 
                INNER JOIN `user_address` ON user.email=user_address.user_email
                INNER JOIN `city_has_district` ON user_address.city_has_district_id_id=city_has_district.city_has_district_id 
                INNER JOIN `city` ON city_has_district.city_city_id=city.city_id 
                INNER JOIN `district` ON city_has_district.district_district_id=district.district_id 
                INNER JOIN `province` ON district.province_province_id=province.province_id 
                WHERE `email`='" . $email . "'");

                $user_address_data = $user_address_rs->fetch_assoc();

                ?>
                <div class="col-12 bg-dark bg-opacity-10 rounded border-top border-2 border-dark border-opacity-25">
                    <div class="row justify-content-center px-2 px-lg-0">
                        <div class="col-12 col-md-8 col-lg-6 border-start border-end bg-body my-3 rounded-2 shadow">
                            <div class="p-3 py-5">
                                <div class="text-center mb-3">
                                    <h4 class="fw-bold">Profile Settings</h4>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 d-flex flex-column align-items-center text-center">

                                        <?php

                                        if ($image_num == 0) {

                                            if ($user_data["gender_name"] == "Male") {
                                        ?>

                                                <img src="resources/userMale.jpg" class="border border-dark border-2 border-opacity-10 rounded-4" style="width: 150px;" id="img" />

                                            <?php
                                            } else {
                                            ?>

                                                <img src="resources/userFemale.png" class="border border-dark border-2 border-opacity-10 rounded-4" style="width: 150px;" id="img" />

                                            <?php
                                            }
                                        } else {

                                            ?>

                                            <img src="<?php echo ($image_data["path"]); ?>" class="border border-dark border-2 border-opacity-10 rounded-4" style="width: 150px;" id="img" />

                                        <?php

                                        }

                                        ?>

                                        <input type="file" class="d-none" id="proImgUploader" accept="image/*" />
                                        <label for="proImgUploader" class="btn btn-outline-primary mt-3 mb-3" onclick="profileImage();">Update Profile Image</label>
                                    </div>
                                    <div class="col-12 col-md-6 pb-2">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" value="<?php echo ($user_data["fname"]) ?>" id="fn" />
                                    </div>
                                    <div class="col-12 col-md-6 pb-2">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" value="<?php echo ($user_data["lname"]) ?>" id="ln" />
                                    </div>
                                    <div class="col-12 col-md-6 pb-2">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" class="form-control" value="<?php echo ($user_data["mobile"]) ?>" id="m" />
                                    </div>
                                    <div class="col-12 col-md-6 pb-2">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php echo ($user_data["password"]) ?>" id="pw">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="bi bi-eye-slash-fill"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-5 pb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" readonly value="<?php echo ($user_data["email"]) ?>" />
                                    </div>
                                    <div class="col-12 col-lg-3 pb-2">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select" id="gender">
                                            <?php

                                            $gender_rs = Database::search("SELECT * FROM `gender`");
                                            $gender_num = $gender_rs->num_rows;

                                            for ($a = 0; $a < $gender_num; $a++) {
                                                $gender_data = $gender_rs->fetch_assoc();

                                            ?>

                                                <option value="<?php echo ($gender_data["id"]); ?>" <?php if ($user_data["gender_id"] == $gender_data["id"]) { ?> selected <?php } ?>><?php echo ($gender_data["gender_name"]); ?></option>

                                            <?php

                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-4 pb-2">
                                        <label class="form-label">Registered Date</label>
                                        <input type="text" class="form-control" readonly value="<?php echo ($user_data["joined_date"]) ?>" />
                                    </div>

                                    <?php

                                    if (!empty($user_address_data["line1"])) {

                                    ?>

                                        <div class="col-12 pb-2">
                                            <label class="form-label">Address Line 1</label>
                                            <input type="text" class="form-control" value="<?php echo ($user_address_data["line1"]) ?>" id="line1" />
                                        </div>

                                    <?php

                                    } else {

                                    ?>

                                        <div class="col-12 pb-2">
                                            <label class="form-label">Address Line 1</label>
                                            <input type="text" class="form-control" id="line1" />
                                        </div>

                                    <?php

                                    }

                                    if (!empty($user_address_data["line2"])) {

                                    ?>

                                        <div class="col-12 pb-2">
                                            <label class="form-label">Address Line 2</label>
                                            <input type="text" class="form-control" value="<?php echo ($user_address_data["line2"]) ?>" id="line2" />
                                        </div>

                                    <?php

                                    } else {

                                    ?>

                                        <div class="col-12 pb-2">
                                            <label class="form-label">Address Line 2</label>
                                            <input type="text" class="form-control" id="line2" />
                                        </div>

                                    <?php

                                    }

                                    ?>


                                    <div class="col-6 pb-2">
                                        <label class="form-label">Province</label>

                                        <select class="form-select" id="province">
                                            <option value="0">Select Province</option>

                                            <?php

                                            $province_rs = Database::search("SELECT * FROM `province`");
                                            $province_num = $province_rs->num_rows;

                                            for ($x = 0; $x < $province_num; $x++) {

                                                $province_data = $province_rs->fetch_assoc();

                                            ?>

                                                <option value="<?php echo ($province_data["province_id"]) ?>" <?php
                                                                                                                if (!empty($user_address_data["province_id"])) {
                                                                                                                    if ($province_data["province_id"] == $user_address_data["province_id"]) { ?> selected <?php }
                                                                                                                                                                                                    } ?>><?php echo ($province_data["province_name"]) ?></option>

                                            <?php

                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-6 pb-2">
                                        <label class="form-label">District</label>
                                        <select class="form-select" id="district">
                                            <option value="0">Select District</option>

                                            <?php
                                            $district_rs = Database::search("SELECT * FROM `district`");

                                            $district_num = $district_rs->num_rows;

                                            for ($y = 0; $y < $district_num; $y++) {

                                                $district_data = $district_rs->fetch_assoc();

                                            ?>

                                                <option value="<?php echo ($district_data["district_id"]) ?>" <?php if (!empty($user_address_data["district_id"])) {
                                                                                                                    if ($district_data["district_id"] == $user_address_data["district_id"]) { ?> selected <?php }
                                                                                                                                                                                                    }  ?>><?php echo ($district_data["district_name"]) ?></option>

                                            <?php

                                            }

                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-6 pb-2">
                                        <label class="form-label">City</label>
                                        <select class="form-select" id="city">
                                            <option value="0">Select City</option>

                                            <?php

                                            $city_rs = Database::search("SELECT * FROM `city`");

                                            $city_num = $city_rs->num_rows;

                                            for ($z = 0; $z < $city_num; $z++) {

                                                $city_data = $city_rs->fetch_assoc();

                                            ?>

                                                <option value="<?php echo ($city_data["city_id"]) ?>" <?php if (!empty($user_address_data["city_id"])) {
                                                                                                            if ($city_data["city_id"] == $user_address_data["city_id"]) { ?> selected <?php }
                                                                                                                                                                                }  ?>><?php echo ($city_data["city_name"]) ?></option>

                                            <?php

                                            }

                                            ?>

                                        </select>
                                    </div>

                                    <?php

                                    if (!empty($user_address_data["postal_code"])) {

                                    ?>

                                        <div class="col-6 pb-2">
                                            <label class="form-label">Postal Code (Optional)</label>
                                            <input type="text" class="form-control" value="<?php echo ($user_address_data["postal_code"]) ?>" id="pcode" />
                                        </div>

                                    <?php

                                    } else {

                                    ?>

                                        <div class="col-6 pb-2">
                                            <label class="form-label">Postal Code (Optional)</label>
                                            <input type="text" class="form-control" id="pcode" />
                                        </div>

                                    <?php

                                    }

                                    ?>

                                    <div class="col-12 d-grid mt-1">
                                        <button class="btn btn-outline-primary" onclick="updateProfile();">Update my Profile</button>
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

<?php

} else {
    header("Location:signin.php");
}

?>